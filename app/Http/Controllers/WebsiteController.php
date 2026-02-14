<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Consult;
use Illuminate\Http\Request;
use App\Models\Notices;
use App\Models\Contact;
use App\Models\GalleryImage;
use App\Models\Job;
use App\Models\Application;
use Illuminate\Support\Facades\Mail;


class WebsiteController extends Controller
{
    public function home()
    {
        $notifications = Notices::whereJsonContains('audience', 'general')->latest()->get();
        $images = GalleryImage::where('is_featured',1)->get();
        // dd($images);
        return view('website.home', compact('notifications','images'));
    }

    public function gallery(){
        $images = GalleryImage::where('is_featured',0)->get();
        return view('website.gallery',compact('images'));
    }
    public function branches(){
        $branches = Branch::all();
        return view('website.branches',compact('branches'));
    }
    public function contactus(){
        return view('website.contactus');
    }
    public function aboutus(){
        return view('website.aboutus');
    }
    public function career(){
        $jobs = Job::all();
        return view('website.career',compact('jobs'));
    }

    public function shownotice($id)
    {
        $notification = Notices::findOrFail($id); // Fetch notification details
        return view('website.noticeshow', compact('notification'));
    }

    public function contactSubmit(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'nullable|email',  // Optional email
            'phone' => 'required|string|max:10',
            'subject' => 'required|string|max:255',
            'comment' => 'required|string',
        ]);

        Contact::create($validatedData);

        //Send email (optional)

        // Mail::send([], [], function ($message) use ($validatedData) {
        //     $message->to('godop0122@gmail.com')
        //         ->subject('New Contact Form Submission')
        //         ->setBody('
        //             Name: ' . $validatedData['name'] . '<br>
        //             Email: ' . ($validatedData['email'] ?? 'Not Provided') . '<br>
        //             Phone: ' . $validatedData['phone'] . '<br>
        //             Subject: ' . $validatedData['subject'] . '<br>
        //             Message: ' . $validatedData['comment'],
        //             'text/html'
        //         );
        // });

        return redirect()->back()->with('success', 'Your message has been send successfully!');
    }

    public function consultSubmit(Request $request){
        $validatedData = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'nullable|email',  // Optional email
            'phone' => 'required|string|max:10',
            'subject' => 'required|string|max:255',
            'comment' => 'required|string',
        ]);

        Consult::create($validatedData);
        return redirect()->back()->with('success', 'Your message has been send successfully!');
    }


    public function jobApply(Request $request)
    {
        // dd($request);
        $request->validate([
            'job_id' => 'required|exists:jobs,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'resume' => 'required|mimes:pdf,doc,docx|max:2048',
            'cover_letter' => 'nullable',
        ]);

        $resumePath = $request->file('resume')->store('resumes', 'public');

        Application::create([
            'job_id' => $request->job_id,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'resume' => $resumePath,
            'message' => $request->cover_letter,
        ]);

        return back()->with('success', 'Application submitted successfully!');
    }
}
