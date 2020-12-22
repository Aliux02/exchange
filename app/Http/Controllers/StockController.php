<?php

namespace App\Http\Controllers;
use App\Models\Trade;
use App\Models\Stock;
use App\Http\Controllers\TradeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stocks = Stock::all();

        return view('stock.index',['stocks'=> $stocks]);
    }

    public function sort($smt)
    {
        $stocks = Stock::all();
        
        if ($smt == 'name_az') {
            $stocks = Stock::all()->sortByDesc('name');
        }
        if ($smt == 'name_za') {
            $stocks = Stock::all()->sortBy('name');
        }

        if ($smt == 'acronym_az') {
            $stocks = Stock::all()->sortByDesc('acronym');
        }
        if ($smt == 'acronym_za') {
            $stocks = Stock::all()->sortBy('acronym');
        }
        
        if ($smt == 'price_up' || $smt == 'price_down') {
            for ($a=0; $a < count($stocks); $a++) { 
                for ($i=0; $i < count($stocks)-1; $i++) { 
                    if ($smt == 'price_up') {
                        if ($stocks[$a]->lastPrice() < $stocks[$i]->lastPrice()) {
                            $temp = $stocks[$a];
                            $stocks[$a] = $stocks[$i];
                            $stocks[$i] = $temp;
                        }
                    }else{
                        if ($stocks[$a]->lastPrice() > $stocks[$i]->lastPrice()) {
                            $temp = $stocks[$a];
                            $stocks[$a] = $stocks[$i];
                            $stocks[$i] = $temp;
                        }
                    }
                }
                
            }
        }

        if ($smt == 'movement_up' || $smt == 'movement_down') {
            for ($a=0; $a < count($stocks); $a++) { 
                for ($i=0; $i < count($stocks)-1; $i++) { 
                    if ($smt == 'movement_up') {
                        if ($stocks[$a]->priceMovement() < $stocks[$i]->priceMovement()) {
                            $temp = $stocks[$a];
                            $stocks[$a] = $stocks[$i];
                            $stocks[$i] = $temp;
                        }
                    }else{
                        if ($stocks[$a]->priceMovement() > $stocks[$i]->priceMovement()) {
                            $temp = $stocks[$a];
                            $stocks[$a] = $stocks[$i];
                            $stocks[$i] = $temp;
                        }
                    }
                }
                
            }
        }

        if ($smt == 'volume_up' || $smt == 'volume_down') {
            for ($a=0; $a < count($stocks); $a++) { 
                for ($i=0; $i < count($stocks)-1; $i++) { 
                    if ($smt == 'volume_up') {
                        if ($stocks[$a]->tradeCount() < $stocks[$i]->tradeCount()) {
                            $temp = $stocks[$a];
                            $stocks[$a] = $stocks[$i];
                            $stocks[$i] = $temp;
                        }
                    }else{
                        if ($stocks[$a]->tradeCount() > $stocks[$i]->tradeCount()) {
                            $temp = $stocks[$a];
                            $stocks[$a] = $stocks[$i];
                            $stocks[$i] = $temp;
                        }
                    }
                }
                
            }
        }return view('stock.index',['stocks'=> $stocks]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),
        [
            'name' => ['required','min:3','max:64'],
            'acronym' => ['required','unique:stocks','min:3','max:3'],

        ],
        [
            'name.required' => 'Akcijos vardas privalomas',
            'name.min' => 'Akcijos vardas per trumpas',
            'name.max' => 'Akcijos vardas per ilgas',

            'acronym.required' => 'Akcijos kodas privalomas',
            'acronym.unique' => 'Akcijos kodas turi buti unikalus',
            'acronym.min' => 'Akcijos kodas per trumpas',
            'acronym.max' => 'Akcijos kodas per ilgas',
        ]);
            if ($validator->fails()) {
                $request->flash();
                return redirect()->back()->withErrors($validator);
            }

        $stock = new Stock();
        $stock->name = ucwords(strtolower($request->name));
        $stock->acronym = strtoupper($request->acronym);
        $stock->save();

        // $trade = new Trade();
        // $trade->quantity = 0;
        // $trade->price = 0;
        // $trade->stock_id = $stock->id;
        // $trade->save();

        return redirect()->route('stock.index')->with('success_message','Akcija '.$stock->acronym.'sekmingai prideta');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function show(Stock $stock)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function edit(Stock $stock)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Stock $stock)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function destroy(Stock $stock)
    {
        //
    }
}
