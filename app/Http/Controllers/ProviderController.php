<?php

namespace App\Http\Controllers;

use App\Booking;
use App\BookingPayment;
use App\BookingProviderReview;
use App\Helpers\Helper;
use App\Provider;
use App\Settings;
use App\Space;
use App\StaticPage;
use Auth;
use Illuminate\Http\Request;
use Validator, DB, Hash, Exception;

class ProviderController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {

        $this->middleware('auth:provider');
    }
    /**
     * @method index()
     * 
     * @uses to display the provider index
     *
     * @created BALAJI M
     *
     * @updated
     *
     * @param NULL
     *
     * @return view index
     *
     */
    public function index()
    {
        $provider_id = Auth::guard('provider')->user()->id ;

        $booking_payments = BookingPayment::where('provider_id', $provider_id);

        $bookings = Booking::where('provider_id', $provider_id);

        $spaces = Space::where('provider_id', $provider_id);

        $data['total_bookings'] = $bookings->count();
        $data['completed_bookings'] = $bookings->where('status',COMPLETED)->count();
        $data['cancelled_bookings'] = $bookings->where('status',CANCELLED)->count();
        $data['total_spaces'] =  $spaces->count();
        $data['approved_spaces'] = $spaces->where('status',PUBLISHED)->count();
        $data['declined_spaces'] = $spaces->where('status',UNPUBLISHED)->count();

    	return view('provider.dashboard')->with('page' , 'index')
                                        ->with('data' , $data)
                                        ->with('booking_payments', $booking_payments)
                                        ->with('bookings', $bookings)
                                        ->with('spaces', $spaces);
                                        
    }
    /**
     * @method profile()
     * 
     * @uses to display the provider profile
     *
     * @created BALAJI M
     *
     * @updated
     *
     * @param integer provider id
     *
     * @return view profile
     *
     */
    public function profile(Request $request) {

        $provider_details = Provider::find(Auth::guard('provider')->user()->id);

        return view('provider.profile.profile')->with('provider_details' , $provider_details);
    }
    /**
     * @method profile_save()
     * 
     * @uses to view provider profile
     *
     * @created BALAJI M
     *
     * @updated 
     *
     * @param integer id
     *
     * @return provider profile page
     *
     */
    public function profile_save(Request $request) {

        try {

            $validator = Validator::make($request->all() , [

                'name' => 'min:3|max:255|regex:/^[a-z A-Z]+$/',

                'email' => 'email|unique:providers,email,'.$request->provider_id.'|max:255',

                'description' => 'min:5|max:255',

                'picture' => 'image|nullable|max:2999|mimes:jpeg,bmp,png,jpg',

                'full_address' => 'min:3|max:30',

                'mobile' => 'digits_between:4,16',

                'picture' => 'mimes:jpeg,jpg,bmp,png',

                ]);

            if($validator->fails()) {

                $errors = implode(',',$validator->messages()->all());

                throw new Exception($errors ,106);
            }

            DB::begintransaction();

            $provider_details = Provider::find($request->provider_id);

            if(!$provider_details) {

                throw new Exception(tr('provider_not_found'), 101);
            }

            $provider_details->name =  $request->name ?: $provider_details->name;

            $provider_details->email =  $request->email ?: $provider_details->email;

            $provider_details->mobile =  $request->mobile ?: $provider_details->mobile;

            $provider_details->description =  $request->description ?: $provider_details->description;

            $provider_details->full_address =  $request->full_address ?: $provider_details->full_address;

            if($request->hasFile('picture')) {

                delete_picture($provider_details->picture, PROFILE_PATH_PROVIDER);

                $provider_details->picture = upload_picture($request->file('picture'),PROFILE_PATH_PROVIDER);
            }

            if($provider_details->save()) {

                DB::commit();

                return back()->with('success', tr('profile_updated'));
            }

            throw new Exception(tr('provider_details_not_saved'),101);
                 
        } catch (Exception $e) {

            DB::rollback();

            return back()->with('error', $e->getMessage());     
        }
    }
    /**
     * @method change_password()
     * 
     * @uses to change provider password
     *
     * @created BALAJI M
     *
     * @updated 
     *
     * @param integer id
     *
     * @return provider profile page
     *
     */
    public function change_password(Request $request) {

        try {

            $validator = Validator::make($request->all(), [  

                'password' => 'required|confirmed|min:6',
                'old_password' => 'required',
            ]);

            if($validator->fails()) {

                $errors = implode(',',$validator->messages()->all());

                throw new Exception($errors, 106);    
            }

            DB::begintransaction();

            $provider_details = Provider::find($request->provider_id);

            if(!$provider_details) {

                throw new Exception(tr('provider_not_found'), 101); 
            }

            if(Hash::check($request->old_password,$provider_details->password)) {

                $provider_details->password = Hash::make($request->password);

                if($provider_details->save()) {

                    DB::commit();

                    return back()->with('success', tr('password_change_success'));    
                }

                throw new Exception(tr('provider_details_not_saved'), 101);    
            } 

            throw new Exception(tr('password_not_match'), 108);
    
        } catch (Exception $e) {

            DB::rollback();

            return back()->with('error', $e->getMessage());   
        }
    }
    /**
     * @method profile_delete()
     * 
     * @uses to delete provider account
     *
     * @created BALAJI M
     *
     * @updated 
     *
     * @param integer provider id
     *
     * @return response success/failure
     *
     */
    public function profile_delete(Request $request) {

        try{

            DB::beginTransaction();
        
            $provider_details = Provider::find($request->provider_id);
       
            if (\Hash::check($request->password, $provider_details->password)) {

                $provider_details->delete();

                DB::commit();

                return redirect()->route('provider.login')->with('success', tr('account_deleted'));
            }

            throw new Exception(tr('password_not_match'));

        } catch(Exception $e){

            DB::rollback();

            return redirect()->back()->with('error',$e->getMessage());
        }
        
    }
    /**
     * @method pages()
     * 
     * @uses to display the static pages
     *
     * @created BALAJI M
     *
     * @updated
     *
     * @param page type
     *
     * @return view of static-page
     *
     */
    public function pages(Request $request) {
        
        $page_details = StaticPage::where('type',$request->page_type)->where('status',APPROVED)->first();

        return view('static-pages.providers-static-page')->with('page_details', $page_details);
    }

    /**
     * @method spaces_index()
     * 
     * @uses to list the spaces
     *
     * @created BALAJI M
     *
     * @updated 
     *
     * @param 
     *
     * @return spaces index page
     *
     */
    public function spaces_index() {

        $spaces = Space::where('provider_id', Auth::guard('provider')->user()->id)->orderBy('created_at', 'desc')->paginate(10);

        return view('provider.spaces.index')->with('page' , 'spaces')->with('spaces', $spaces);
    }
    /**
     * @method spaces_create()
     * 
     * @uses to create the spaces
     *
     * @created BALAJI M
     *
     * @updated 
     *
     * @param 
     *
     * @return spaces create form
     *
     */
    public function spaces_create() {

        $space_details = new Space;

        return view('provider.spaces.create')->with('page' , 'spaces')
                                            ->with('sub_page' , 'add_space')
                                            ->with('space_details', $space_details);
    }
    /**
     * @method spaces_save()
     * 
     * @uses to save the spaces details
     *
     * @created BALAJI M
     *
     * @updated 
     *
     * @param integer space id
     *
     * @return spaces create form
     *
     */
    public function spaces_save(Request $request) {

        try {


            $validator = Validator::make($request->all() , [

                'name' => 'required|min:3|max:100|regex:/^[a-z A-Z]+$/',
                'tagline' => 'required|min:5|max:10',
                'space_type' => 'required',
                'description' => 'required|min:5|max:300',
                'instructions' => 'required|min:5|max:200',
                'per_hour' => 'required|min:1|max:1000|numeric',
                'picture' => 'image|nullable|max:2048|mimes:jpeg,bmp,png,jpg',
                'full_address' => 'required|min:10|max:300',

                ]);

            if($validator->fails()) {

                $errors = implode(',',$validator->messages()->all());

                throw new Exception($errors ,106);
            }

            DB::begintransaction();

            if(!$request->space_id) {

                $space_details = new Space;

                $space_details->unique_id = uniqid(base64_encode(str_random(10)));

                $space_details->provider_id = Auth::guard('provider')->user()->id;

                $message = tr('space_add_success');

            } else {

                $space_details = Space::find($request->space_id);


                if(!$space_details) {

                    throw new Exception(tr('space_not_found'), 101);
                }

                $message = tr('space_details_updated');
            }
                
            $space_details->name =  $request->name ?: $space_details->name;

            $space_details->tagline =  $request->tagline ?: $space_details->tagline;

            $space_details->space_type =  $request->space_type ?: $space_details->space_type;

            $space_details->per_hour =  $request->per_hour ?: $space_details->per_hour;

            $space_details->description =  $request->description ?: $space_details->description ;

            $space_details->instructions =  $request->instructions ?: $space_details->instructions ;

            $space_details->status =  UNPUBLISH ;

            $space_details->admin_status = SPACE_DECLINED;

            $space_details->full_address =  $request->full_address ?: $space_details->full_address ;

            if($request->hasFile('picture')) {

                delete_picture($space_details->picture, FILE_PATH_SPACE);

                $space_details->picture = upload_picture($request->file('picture'),FILE_PATH_SPACE);
            }

            if($space_details->save()) {

                DB::commit();

                return redirect()->route('provider.spaces.view',['space_id'=>$space_details->id])->with('success', $message);
            }

            throw new Exception(tr('space_details_not_saved'),101);
                 
        } catch (Exception $e) {

            DB::rollback();

            return back()->withInput()->with('error', $e->getMessage());     
        }
        
    }
    /**
     * @method spaces_edit()
     * 
     * @uses to edit the spaces
     *
     * @created BALAJI M
     *
     * @updated 
     *
     * @param 
     *
     * @return spaces edit form
     *
     */
    public function spaces_edit(Request $request) {

        try {

            $space_details = Space::find($request->space_id);

            if(!$space_details){

                throw new Exception(tr('space_not_found'), 101);
            }

            return view('provider.spaces.edit')->with('page' , 'spaces')->with('space_details',$space_details);

        } catch (Exception $e) {

            return back()->with('error', $e->getMessage());
        }

    }
    /**
     * @method spaces_view()
     * 
     * @uses to view the space details
     *
     * @created BALAJI M
     *
     * @updated
     *
     * @param integer space id
     *
     * @return space details view
     *
     */ 
    public function spaces_view(Request $request){

        try {

            $space_details = Space::find($request->space_id);

            if($space_details){

                return view('provider.spaces.view')->with('page' , 'spaces')->with('sub_page','view_space')->with('space_details',$space_details);
            }

            throw new Exception(tr('space_not_found'), 101);
            
        } catch (Exception $e) {
            
            return back()->with('error', $e->getMessage());
        }
    }
    /**
     * @method spaces_status()
     * 
     * @uses to change the space status
     *
     * @created BALAJI M
     *
     * @updated
     *
     * @param integer space id
     *
     * @return spaces index
     *
     */ 
    public function spaces_status(Request $request){

        try {

            DB::beginTransaction();

            $space_details = Space::find($request->space_id);

            if($space_details) {

                $space_details->status  = $space_details->status == PUBLISHED ? UNPUBLISHED : PUBLISHED ;

                $space_details->save();

                DB::commit();

                $message = $space_details->status == PUBLISHED ? tr('space_published_success') : tr('space_unpublished_success');

                return back()->with('success' , $message);
            }

           throw new Exception(tr('space_not_found'), 101);
                
        } catch (Exception $e) {

            DB::rollback();

            return back()->with('error', $e->getMessage());
        }
    }
    /**
     * @method spaces_delete()
     * 
     * @uses to delete the space details
     *
     * @created BALAJI
     *
     * @updated
     *
     * @param integer space id
     *
     * @return spaces index
     *
     */ 
    public function spaces_delete(Request $request){

        try {

            DB::begintransaction();

            $space_details = Space::find($request->space_id);

            if(!$space_details){

                throw new Exception(tr('spaces_not_found'), 101);    
            }

            if($space_details->delete()){

                DB::commit();

                return redirect()->route('provider.spaces.index')->with('success',tr('space_delete_success'));
            }

            throw new Exception(tr('space_not_delete'), 101);
     
        } catch (Exception $e) {
            
            DB::rollback();

            return back()->with('error', $e->getMessage());
        }
    }
    /**
     * @method bookings_index()
     * 
     * @uses to list the bookings
     *
     * @created BALAJI M
     *
     * @updated 
     *
     * @param integer provider id
     *
     * @return bookings index page
     *
     */
    public function bookings_index() {

        $provider_id = Auth()->guard('provider')->user()->id;


        $bookings = Booking::where('provider_id', $provider_id)->orderBy('created_at', 'desc')->paginate(10);

        return view('provider.bookings.index')->with('page' , 'bookings')->with('bookings', $bookings);
    }
    /**
     * @method bookings_view()
     * 
     * @uses to view the bookings
     *
     * @created BALAJI M
     *
     * @updated 
     *
     * @param integer booking id
     *
     * @return bookings view page
     *
     */
    public function bookings_view(Request $request) {

        try{

            $booking_details = Booking::find($request->booking_id);

            $booking_payment_details = BookingPayment::where('booking_id', $booking_details->id)->first();

            if(!$booking_details){

                throw new Exception(tr('booking_not_found'), 101);     
            }

            return view('provider.bookings.view')->with('page' , 'bookings')
                                                ->with('booking_details', $booking_details)
                                                ->with('booking_payment_details', $booking_payment_details);
                   
        } catch(Exception $e){

            return redirect()->back()->with('error',$e->getMessage());
        }

    }
    /**
     * @method bookings_status()
     * 
     * @uses to change status of the bookings
     *
     * @created BALAJI M
     *
     * @updated 
     *
     * @param integer booking id
     *
     * @return bookings index page
     *
     */
    public function bookings_status(Request $request) {

        try{

            DB::begintransaction();

            $booking_details = Booking::find($request->booking_id);

            if(!$booking_details){

                throw new Exception(tr('booking_not_found'), 101);
            }

            if($booking_details->status == BOOKING_INITIATE) {

                $booking_details->status = CANCELLED;

                $booking_details->save();

                DB::commit();

                return redirect()->back()->with('success',tr('booking_cancelled'));
                
            }

            throw new Exception(tr('booking_not_cancel'), 101);


        } catch(Exception $e){

            DB::rollback();

            return redirect()->back()->with('error',$e->getMessage());
        }
    }
    /**
     * @method bookings_review()
     * 
     * @uses to review the booking
     *
     * @created BALAJI M
     *
     * @updated 
     *
     * @param integer booking id
     *
     * @return bookings view
     *
     */
    public function bookings_review(Request $request) {

        try {

            DB::beginTransaction();

            $validator = Validator::make( $request->all(), [

                'booking_id' => 'required',

                'review' => 'required|min:3',

                'ratings' => 'required|numeric|min:1|max:5',

            ]);

            if($validator->fails()) {

                $error = implode(',', $validator->messages()->all());

                throw new Exception($error, 101);
            }

            $booking_details = Booking::find($request->booking_id);

            if(!$booking_details){

                throw new Exception(tr('booking_not_found'), 101);

            }

            if($booking_details->bookingProviderReviews) {

                throw new Exception(tr('already_review_updated'), 101);
                
            }

            $booking_provider_review = new BookingProviderReview;

            $booking_provider_review->space_id = $booking_details->spaces->id;

            $booking_provider_review->provider_id = Auth::guard('provider')->user()->id ;

            $booking_provider_review->booking_id = $request->booking_id;

            $booking_provider_review->user_id = $booking_details->users->id ;

            $booking_provider_review->review = $request->review;

            $booking_provider_review->ratings = $request->ratings;

            $booking_details->save();

            $booking_provider_review->save();

            DB::commit();

            return redirect()->back()->with('success',tr('review_updated'));

        } catch(Exception $e){

            DB::rollback();

            return redirect()->back()->with('error',$e->getMessage());

        }
    }

}
