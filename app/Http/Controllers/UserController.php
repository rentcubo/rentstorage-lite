<?php

namespace App\Http\Controllers;

use App\Booking;
use App\BookingPayment;
use App\BookingUserReview;
use App\Helpers\Helper;
use App\Space;
use App\StaticPage;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Validator, DB, Hash,Setting , Exception;

class UserController extends Controller
{

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct() {

	    $this->middleware('auth:web');
	}
	/**
	 * @method profile()
	 * 
	 * @uses to display the user profile
	 *
	 * @created BALAJI M
	 *
	 * @updated
	 *
	 * @param integer user id
	 *
	 * @return view profile
	 *
	 */
	public function profile(Request $request) {

	    $user_details = User::find(Auth::guard('web')->user()->id);

	    return view('user.profile.profile')->with('user_details' , $user_details);
	}
	/**
	 * @method profile_save()
	 * 
	 * @uses to view user profile
	 *
	 * @created BALAJI M
	 *
	 * @updated 
	 *
	 * @param integer id
	 *
	 * @return user profile page
	 *
	 */
	public function profile_save(Request $request) {

	    try {

	        $validator = Validator::make($request->all() , [

	        	'first_name' => 'min:3|max:255|regex:/^[a-z A-Z]+$/',

                'last_name' => 'min:1|max:255|regex:/^[a-z A-Z]+$/',

                'description' => 'min:5|max:255',

                'picture' => 'image|nullable|max:2999|mimes:jpeg,bmp,png,jpg',

	            'mobile' => 'digits_between:4,16',

	            'email' => 'email|unique:users,email,'.$request->user_id.'|max:255',

	            ]);

	        if($validator->fails()) {

	            $errors = implode(',',$validator->messages()->all());

	            throw new Exception($errors ,106);
	        }

	        DB::begintransaction();

	        $user_details = User::find($request->user_id);

	        if(!$user_details) {

	            throw new Exception(tr('user_not_found'), 101);
	        }
	            
	        $user_details->first_name =  $request->first_name ?: $user_details->first_name;

	        $user_details->last_name =  $request->last_name ?: $user_details->last_name;

	        $user_details->email =  $request->email ?: $user_details->email;

	        $user_details->mobile =  $request->mobile ?: $user_details->mobile;

	        $user_details->description =  $request->description ?: $user_details->description;

	        if($request->hasFile('picture')) {

	            delete_picture($user_details->picture, PROFILE_PATH_USER);

	            $user_details->picture = upload_picture($request->file('picture'),PROFILE_PATH_USER);
	        }

	        if($user_details->save()) {

	            DB::commit();

	            return back()->with('success', tr('profile_updated'));
	        }

	        throw new Exception(tr('user_details_not_saved'),101);
	             
	    } catch (Exception $e) {

	        DB::rollback();

	        return back()->with('error', $e->getMessage());     
	    }
	}
	/**
	 * @method change_password()
	 * 
	 * @uses to change user password
	 *
	 * @created BALAJI M
	 *
	 * @updated 
	 *
	 * @param integer id
	 *
	 * @return user profile page
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

	        $user_details = User::find($request->user_id);

	        if(!$user_details) {

	            throw new Exception(tr('user_not_found'), 101); 
	        }

	        if(Hash::check($request->old_password,$user_details->password)) {

	            $user_details->password = Hash::make($request->password);

	            if($user_details->save()) {

	                DB::commit();

	                return back()->with('success', tr('password_change_success'));    
	            }

	            throw new Exception(tr('user_details_not_saved'), 101);    
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
	 * @uses to delete user account
	 *
	 * @created BALAJI M
	 *
	 * @updated 
	 *
	 * @param integer user id
	 *
	 * @return response success/failure
	 *
	 */
	public function profile_delete(Request $request) {

	    try{

	        DB::beginTransaction();
	    
	        $user_details = User::find($request->user_id);
	   
	        if (\Hash::check($request->password, $user_details->password)) {

	            $user_details->delete();

	            DB::commit();

	            return redirect()->route('login')->with('success', tr('account_deleted'));
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

	    return view('static-pages.users-static-page')->with('page_details', $page_details);
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

		$spaces = Space::where('admin_status', APPROVED)->where('status', PUBLISHED)->orderBy('created_at', 'desc')->paginate(10);

	    return view('user.spaces.index')->with('page', 'spaces')->with('spaces', $spaces);
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

	            return view('user.spaces.view')->with('page','spaces')
	            								->with('space_details',$space_details);
	        }

	        throw new Exception(tr('space_not_found'), 101);
	        
	    } catch (Exception $e) {
	        
	        return back()->with('error', $e->getMessage());
	    }
	}

	/**
	 * @method bookings_index()
	 * 
	 * @uses used to display the list of booking 
	 *
	 * @created BALAJI M
	 *
	 * @updated
	 *
	 * @param NULL
	 *
	 * @return view of booking list
	 *
	 */
	public function bookings_index() {

	    $bookings = Booking::where('user_id', Auth::guard('web')->user()->id )->orderBy('created_at', 'desc')->paginate(10);

	    return view('user.bookings.index')->with('page', 'bookings')->with('bookings', $bookings);
	                   
	
	}
	/**
	 * @method bookings_save()
	 * 
	 * @uses to create the bookings
	 *
	 * @created BALAJI M
	 *
	 * @updated 
	 *
	 * @param integer booking id
	 *
	 * @return bookings save
	 *
	 */
	public function bookings_save(Request $request) {

		try {

			

			DB::beginTransaction();

			$space_details = Space::find($request->space_id);

			if(!$space_details) {

				throw new Exception(tr('space_not_found'), 101);
			}

			$current_time = convertTimeToUSERzone(now(),$request->timezone);

			$validator = Validator::make( $request->all(), [

				'checkin' => 'required|date_format:"d/m/Y H:i:s"|after:'.$current_time,

				'checkout' => 'required|date_format:"d/m/Y H:i:s"|after:checkin',

				'description' => 'required|min:3|max:255'

			]); 

			if($validator->fails()) {

				$error = implode(',', $validator->messages()->all());

				throw new Exception($error, 101);
			}

			$checkin = Carbon::createFromFormat('d/m/Y H:i:s', $request->checkin);

			$checkout = Carbon::createFromFormat('d/m/Y H:i:s', $request->checkout);

			$duration_min = $checkin->diffInMinutes($checkout);

			$duration = $duration_min/60;

			$per_hour = $space_details->per_hour;

			$total = $duration * $per_hour;

			$booking_details = new Booking;

			$booking_details->unique_id = uniqid();

			$booking_details->user_id = Auth::guard('web')->user()->id;

			$booking_details->provider_id = $space_details->provider_id;

			$booking_details->space_id = $space_details->id;

			$booking_details->description = $request->description;

			$booking_details->checkin = convertTimeToUTCzone($checkin, $request->timezone);

			$booking_details->checkout = convertTimeToUTCzone($checkout, $request->timezone);

			$booking_details->payment_mode = COD;

			$booking_details->currency = setting()->get('currency');

			$booking_details->total_time = $duration;

			$booking_details->per_hour = $per_hour;

			$booking_details->total = $total;

			$booking_details->status = BOOKING_INITIATE;

			$booking_details->save();

			DB::commit();

			return redirect()->route('bookings.view',['booking_id' => $booking_details->id])->with('success', tr('booking_created_successful'));  

		} catch(Exception $e){

			DB::rollback();

			return redirect()->back()->with('error',$e->getMessage());
		}
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

	        if(!$booking_details){

	            throw new Exception(tr('booking_not_found'), 101);     
	        }

            $booking_payment_details = BookingPayment::where('booking_id', $request->booking_id)->first() ;

	        return view('user.bookings.view')->with('page', 'bookings')
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

	        if($booking_details->status == BOOKING_INITIATE){

	        $booking_details->status = CANCELLED ;

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
	 * @method bookings_checkin()
	 * 
	 * @uses to checkin the booking space
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
	public function bookings_checkin(Request $request) {

		try {

			DB::begintransaction();

			$booking_payment_details = BookingPayment::where('booking_id', $request->booking_id)->first();

			if(!$booking_payment_details) {

				throw new Exception(tr('complete_payment'), 101);
				
			}
			
			$booking_details = Booking::find($request->booking_id);

			$booking_details->checkin = now();

			$booking_details->status = BOOKING_CREATED ;

			$booking_details->save();

			DB::commit();

	        return redirect()->back()->with('success',tr('booking_checkin'));

		} catch (Exception $e) {

			DB::rollback();

	        return redirect()->back()->with('error',$e->getMessage());
			
		}
	}
	/**
	 * @method bookings_checkout()
	 * 
	 * @uses to checkout the booking space
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
	public function bookings_checkout(Request $request) {

		try {

			DB::begintransaction();
			
			$booking_details = Booking::find($request->booking_id);

			$booking_details->checkout = now();

			$booking_details->status = COMPLETED ;

			$booking_details->save();

			DB::commit();

	        return redirect()->back()->with('success',tr('booking_checkout'));

		} catch (Exception $e) {

			DB::rollback();

	        return redirect()->back()->with('error',$e->getMessage());
			
		}
	}
	/**
	 * @method bookings_payment()
	 * 
	 * @uses to pay booking amount
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
	public function bookings_payment(Request $request) {

		try {

			DB::begintransaction();
			
			$booking_details = Booking::find($request->booking_id);

			$booking_payment_details = new BookingPayment;

			$booking_payment_details->booking_id = $request->booking_id;

			$booking_payment_details->user_id = $booking_details->user_id;

			$booking_payment_details->provider_id = $booking_details->provider_id;

			$booking_payment_details->space_id = $booking_details->space_id;

			$booking_payment_details->payment_id = uniqid();

			$booking_payment_details->total_time = $booking_details->total_time;

			$booking_payment_details->per_hour = $booking_details->per_hour;

            $booking_payment_details->sub_total = $booking_details->total;

			$booking_payment_details->tax_price = (Setting::get('tax_percentage')/100) * $booking_payment_details->sub_total;

			$booking_payment_details->total = $booking_payment_details->sub_total + $booking_payment_details->tax_price;

			$booking_payment_details->admin_amount = $booking_payment_details->total * ( Setting::get('admin_commission')/100);

			$booking_payment_details->provider_amount = $booking_payment_details->total - $booking_payment_details->admin_amount;

			$booking_payment_details->paid_amount = $booking_payment_details->total;

			$booking_payment_details->paid_date = now();

			$booking_payment_details->status = PAID ;

			$booking_payment_details->save();

			DB::commit();

	        return redirect()->back()->with('success',tr('booking_payment_successful'));

		} catch (Exception $e) {

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

            $booking_details = Booking::find($request->booking_id);

            if(!$booking_details){

                throw new Exception(tr('booking_not_found'), 101);

            }

            if($booking_details->bookingUserReviews) {

                throw new Exception(tr('already_review_updated'), 101);
                
            }

            $validator = Validator::make( $request->all(), [

                'booking_id' => 'required',

                'review' => 'required|min:3',

                'ratings' => 'required|numeric|min:1|max:5',

            ]);

            if($validator->fails()) {

                $error = implode(',', $validator->messages()->all());

                throw new Exception($error, 101);
            }

            $booking_user_review = new BookingUserReview;

            $booking_user_review->space_id = $booking_details->spaces->id;

            $booking_user_review->provider_id = $booking_details->providers->id;

            $booking_user_review->booking_id = $request->booking_id;

            $booking_user_review->user_id = Auth::guard('web')->user()->id ;

            $booking_user_review->review = $request->review;

            $booking_user_review->ratings = $request->ratings;

            $booking_details->save();

            $booking_user_review->save();

            DB::commit();

            return redirect()->back()->with('success',tr('review_updated'));

        } catch(Exception $e){

            DB::rollback();

            return redirect()->back()->with('error',$e->getMessage());

        }
    }
}
