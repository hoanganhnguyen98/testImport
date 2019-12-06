<?php

namespace App\Http\Controllers\Receptionist;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Lang;
use App\Model\Table;
use App\Model\Bill;
use App\Model\BillDetail;
use App\Model\Food;
use Auth;
use PDF;

class BillController extends Controller
{
    /**
     * Show create bill form.
     *
     * @param $table_id
     * @return \Illuminate\Http\Response
     */
    protected function showCreateBillForm($table_id)
    {
        if (Auth::user()->role == 'receptionist') {
            // update status for table
            $new_status = 'prepare';
            $table = Table::where('table_id', $table_id)->first();
            $table->status = $new_status;
            $table->save();

            return view('user.receptionist.bill.create-bill', compact('table_id'));
        } else {
            return view('404');
        }
    }

    /**
     * Cancel create new bill.
     *
     * @param $table_id
     * @return \Illuminate\Http\Response
     */
    protected function cancelCreateBill($table_id)
    {
        if (Auth::user()->role == 'receptionist') {
            // update status for table
            $new_status = 'ready';
            $table = Table::where('table_id', $table_id)->first();
            $table->status = $new_status;
            $table->save();
            return redirect()->route('home');
        } else {
            return view('404');
        }
    }

    /**
     * Cancel create new bill.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    protected function createBill(Request $request)
    {
        try {
            DB::beginTransaction();

            $rules = [
                'table_id' => ['required'],
                'name' => ['required', 'string', 'max:255'],
                'phone' => ['required', 'regex:/(0)[0-9]{9}/'],
                'city' => ['required', 'string', 'max:255'],
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            // update status for table
            $new_status = 'run';
            $table = Table::where('table_id', $request->table_id)->first();
            $table->status = $new_status;
            $table->save();

            Bill::create([
                'receptionist_id' => Auth::user()->user_id,
                'table_id' => $request->table_id.'-'.Auth::user()->area,
                'customer_name' => $request->name,
                'street' => $request->street,
                'district' => $request->district,
                'city' => $request->city,
                'phone' => $request->phone,
                'email' => $request->email,
            ]);

            DB::commit();

            $success = Lang::get('notify.success.create-bill');
            return redirect()->route('home')->with('success', $success);
        } catch (Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('errors', $e->getMessage());
        }
    }

    /**
     * Get bill list.
     *
     * @return \Illuminate\Http\Response
     */
    protected function showBillList()
    {
        if (Auth::user()->role == 'receptionist') {
            $area = Auth::user()->area;
            $today = date('Y-m-d');
            $today_bills = Bill::whereDate('created_at', $today);

            $bills = $today_bills->sortable('id')->paginate(10);

            return view('user.receptionist.bill.bill-list', compact('bills', 'area'));
        } else {
            return view('404');
        }
    }

    /**
     * Show edit bill form.
     *
     * @param $table_id
     * @return \Illuminate\Http\Response
     */
    protected function showEditBillForm($table_id)
    {
        
    }

    /**
     * Show pay bill form.
     *
     * @param $table_id
     * @return \Illuminate\Http\Response
     */
    protected function showPayBillForm($table_id)
    {
        if (Auth::user()->role == 'receptionist') {
            // get table id to get current bill in this table
            $table_id = $table_id.'-'.Auth::user()->area;
            $bill = Bill::where([['table_id', $table_id], ['status', 'new']])->first();
            
            $output = $this->getBillDetail($bill);

            $bill_details = $output[0];
            $vndPrice  = $output[1];

            return view('user.receptionist.bill.pay-bill.pay-bill',
                compact('bill', 'bill_details', 'vndPrice'));
        } else {
            return view('404');
        }
    }

    /**
     * Export red bill.
     *
     * @param $table_id
     * @return \Illuminate\Http\Response
     */
    protected function exportRedBill($table_id)
    {
        $user = Auth::user();
        $bill = Bill::where([['table_id', $table_id], ['status', 'new']])->first();
        $now = date("Y-m-d H:i:s");

        $output = $this->getBillDetail($bill);
        $bill_details = $output[0];
        $vndPrice  = $output[1];

        // $pdf = PDF::loadView('user.receptionist.bill.pay-bill.red-bill',
        //     compact('bill', 'now', 'bill_details', 'vndPrice', 'usdPrice'));
        // return $pdf->stream();
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->WriteHTML(\View::make('user.receptionist.bill.pay-bill.red-bill',
            compact('user', 'bill', 'now', 'bill_details', 'vndPrice')));
        $mpdf->debug = true;
        $mpdf->Output();
    }

    /**
     * Format bill detail.
     *
     * @param $bill
     * @return \Illuminate\Http\Response
     */
    private function getBillDetail($bill)
    {
        //get all bill detail of current bill
        $bill_id = $bill->id;
        $current_bill_details = BillDetail::where([['bill_id', $bill_id], ['status', 'done']])->get();

        // get array include food id and number
        $bill_foods = array();
        foreach ($current_bill_details as $current_bill_detail) {
            $a['food_id'] = $current_bill_detail->food_id;
            $a['number'] = $current_bill_detail->number;
            $bill_foods[] = $a;
        }

        // merge same food id and increase number
        for ($i = 0; $i < count($bill_foods) ; $i++) {
            for ($j = $i + 1; $j < count($bill_foods); $j++) {
                if ($bill_foods[$i]['food_id'] == $bill_foods[$j]['food_id']) {
                    $bill_foods[$i]['number'] = $bill_foods[$i]['number'] + $bill_foods[$j]['number'];
                    $bill_foods[$j]['number'] = 0;
                }
            }
        }

        // delete food_id with number = 0
        $bill_mergeds = array();
        foreach ($bill_foods as $bill_food) {
            if ($bill_food['number'] != 0) {
                $bill_mergeds[] = $bill_food;
            }
        }

        // get name and price for each bill detail
        $bill_details = array();
        $vndPrice  = 0;
        $usdPrice = 0;
        foreach ($bill_mergeds as $bill_merged) {
            $food_id = $bill_merged['food_id'];
            $food = Food::where('id', $food_id)->first();

            // create a new array to store all key and value of each bill detail
            $food_detail = array();
            $food_detail['food_id'] = $food_id;
            $food_detail['number'] = $bill_merged['number'];
            $food_detail['name'] = $food->name;
            $food_detail['vnd_price'] = explode('.', $food->vnd_price)[0];
            $food_detail['usd_price'] = explode('.', $food->usd_price)[0];
            $food_detail['vnd_total'] = $bill_merged['number']*$food->vnd_price;

            $vndPrice = $vndPrice + $food_detail['vnd_total'];
            // put into a single array
            $bill_details[] = $food_detail;
        }
        $output = array($bill_details, $vndPrice, $usdPrice);
        return $output;
    }
}
