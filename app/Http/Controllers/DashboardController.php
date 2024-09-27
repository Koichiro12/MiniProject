<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Transactions;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DashboardController extends Controller
{
    //
    public function index(Request $request){
        $labels = [];
        $color = [];
        $dataIn = [];
        $dataOut = [];  
        $amountIn = 0;
        $amountOut = 0;
        $countIn = 0;
        $countOut = 0;
        

        $category = Category::all();
        $transactions = Transactions::all();
        
        foreach($category as $c){
            array_push($labels,$c->category_name);
            array_push($color,$c->category_color);
            $valData = 0;
            $inData = 0;
            $outData = 0;
            foreach($transactions as $t){
                if($t->category_id == $c->id){
                    $t->type == 'in' ? $valData += $t->amount : $valData -= $t->amount;
                    $t->type == 'in' ? $inData += $t->amount : $outData += $t->amount;
                    $t->type == 'in' ? $countIn++ : $countOut++;
                }
            }
            $amountIn += $inData;
            $amountOut += $outData;
            array_push($dataIn,$inData);
            array_push($dataOut,$outData);
        }
        $data = [
            'labels' => $labels,
            'inData' => $dataIn,
            'outData' => $dataOut,
            'amountIn' => $amountIn,
            'amountOut' => $amountOut,
            'countIn' => $countIn,
            'countOut' => $countOut,
            'colors' => $color
        ];
        return view('pages.Dashboard',compact(['category','transactions','data']));
    }
    public function listTransactions(Request $request){
        if($request->ajax()){
            $transactions = Transactions::query();
            return DataTables::of($transactions)
            ->addColumn('detail_transactions',function($transactions){
                return "<p>".$transactions->Category->category_name."</p>"."<small>Rp.".number_format($transactions->amount).",- ".date_format(date_create($transactions->date_input),'d-m-Y')."</small>";
            })
            ->rawColumns(columns: ['detail_transactions'])
            ->make(true);
        }
    }
    public function transactionStore(Request $request){
        $validate = \Validator::make($request->all(),[
            'category_id' => ['required'],
            'type' => ['required'],
            'amount' => ['required'],
            'date_input' => ['required']
        ]);
        if(!$validate){
            return redirect()->back()->withErrors($validate)->withInput();
        }
        $insert = Transactions::create([
            'category_id' => $request->category_id,
            'type' => $request->type,
            'amount' => $request->amount,
            'date_input' => $request->date_input,
        ]);
        if($insert){
            return redirect()->back()->with('success',"Insert Data SuccessFully");
        }
        return redirect()->back()->with('error',"Oops,Something Went wrong, please try again !");
    }
    public function transactionDelete(string $id){
        $oldData = Transactions::findOrFail($id);
        $oldData->delete();
        return redirect()->back()->with('success',"Delete Data SuccessFully");
    }

}
