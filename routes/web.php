<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});

Route::post("/lead", function(Request $request) {
    $lead_last_id = DB::table("leads")->insertGetId([
        "name" => $request->input("name"),
        "email" => $request->input("email"),
        "phone" => $request->input("phone"),
        "source" => $request->server("HTTP_REFERER")
    ]);

    $email = array(
        "name" => $request->input("name"),
        "email" => $request->input("email"),
        "phone" => $request->input("phone"),
        "source" => $request->fullUrl(),
        "lead_id" => $lead_last_id
    );

    $list_id = "f315a1ed5c";
    $mailchimp = new Mailchimp("aeb1391031954768639c82b75a9fdc30-us11");
    $mailchimp->lists->subscribe(
        $list_id,
        ["email" => $request->input("email")]
    );
/*
    Mail::send("email.lead", $email, function ($message) {
        $message->from("genlid.proposals@gmail.com", "genlid.proposals");
        $message->to("nitrolovsky@gmail.com");
        $message->subject("Заявка № " . date ("Y.m.d H:m:s"));
    });

    Mail::send("email.lead", $email, function ($message) {
        $message->from("genlid.proposals@gmail.com", "genlid.proposals");
        $message->to("domshowaltair@gmail.com");
        $message->subject("Заявка № " . date ("Y.m.d H:m:s"));
    });*/
});
