<?php

namespace App\Http\Controllers;

use App\Models\ContactUs;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Attribute;
use App\Models\Color;
use App\Models\AttributeTranslation;
use App\Models\AttributeValue;
use CoreComponentRepository;
use Illuminate\Http\Response;
use Str;

class ContactUsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        CoreComponentRepository::initializeCache();
        $contacts = ContactUs::orderBy('created_at', 'desc')->get();
        return view('backend.contactUs.index', compact('contacts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function form()
    {
        return view('frontend.aboutUs.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required',
            'email'         => 'required|email',
            'phoneNumber'   => '',
            'message'       => 'required',
        ]);

        $response['status'] = 'Error';

        ContactUs::create($request->all());

        flash(translate('Thanks for contacting us!'))->success();
        return redirect()->route('contact-us.form');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {

        Attribute::destroy($id);
        flash(translate('Contact Message has been deleted successfully'))->success();
        return redirect()->route('contact-us.index');

    }
    
}
