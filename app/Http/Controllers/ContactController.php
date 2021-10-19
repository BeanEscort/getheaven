<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Mail\Mailable;
use Mail;
use App\Mail\SendMail;

class ContactController extends Controller
{
	protected $rules = [
        	'name' => 'required|min:6',
        	'email' => 'required|email:filter',
        	'message' => 'required'
        ];

        protected $messages = [
        	'name.required' => 'O campo Nome é obrigatório!!',
        	'name.min' => 'O campo Nome deve ter no mínimo 3 caracteres!!',
        	'email.required' => 'O E-mail é obrigatório!!',
        	'email.email' => 'Digite um e-mail válido!!',
        	'message.required' => 'Você deve digitar uma mensagem.'
        ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('contact.index');
    }

    public function saveMessage(Request $request){
	
	$this->validate($request, $this->rules, $this->messages);

	$data = array(
		'name' => $request->name,
		'email' => $request->email,
		'message' => $request->message
	);

	Mail::to('marcos_prog@yahoo.com.br')->send(
            new SendMail(
                $data
                )
        );
//	Session::flash('success', 'Obrigado por nos contactar <br/>Em breve retornaremos seu contato!!'); 
	return back()->with('success', 'Obrigado por nos contactar, em breve retornaremos seu contato!');
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
