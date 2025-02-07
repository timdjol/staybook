<?php


use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\HotelController;
use App\Http\Controllers\Admin\ListbookController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\PageController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('locale/{locale}', 'App\Http\Controllers\MainController@changeLocale')->name('locale');
Route::get('/logout', 'App\Http\Controllers\ProfileController@logout')->name('get-logout');


Route::middleware('set_locale')->group(function ()
{

        Route::group(["prefix" => "auth"], function ()
        {
            Route::resource("hotels", "App\Http\Controllers\Admin\HotelController");
            Route::resource("services", "App\Http\Controllers\Admin\ServiceController");
            Route::resource("payments", "App\Http\Controllers\Admin\PaymentController");
            Route::resource("listbooks", "App\Http\Controllers\Admin\ListbookController");
            Route::resource("bookings", "App\Http\Controllers\Admin\BookingController");
            Route::resource("prices", "App\Http\Controllers\Admin\PriceController");
            Route::resource("rooms", "App\Http\Controllers\Admin\RoomController");
            Route::resource("categories", "App\Http\Controllers\Admin\CategoryRoomController");
            Route::resource("foods",    "App\Http\Controllers\Admin\FoodController");
            Route::resource("rules", "App\Http\Controllers\Admin\RuleController");
            Route::resource("childs", "App\Http\Controllers\Admin\ChildController");
            Route::resource("pages", "App\Http\Controllers\Admin\PageController");
            Route::resource("images", "App\Http\Controllers\Admin\ImageController");
            Route::resource("bills", "App\Http\Controllers\Admin\BillController");
            Route::resource("users", "App\Http\Controllers\Admin\UserController");
            Route::resource("roles", "App\Http\Controllers\Admin\RoleController");
            Route::resource("permissions", "App\Http\Controllers\Admin\PermissionController");
            Route::resource("contacts", "App\Http\Controllers\Admin\ContactController");

            Route::get("search",[HotelController::class,'search']);
            Route::get("searchbook",[ListBookController::class,'searchbook']);


//                Route::get('/hotels/{status?}/{show_result?}/{s_query?}', [HHotelController::class, 'index'])->name
//                ('hotels.index');
//                Route::get('/rooms/{status?}/{show_result?}/{s_query?}', [RoomController::class, 'index'])->name
//                ('rooms.index');

            Route::get('generate-pdf/{id}', [PDFController::class, 'generatePDF'])->name('pdf');

            //Route::get('/books/index', [BookingController::class, 'index'])->name('books.index');
            //Route::get('/books/create', [BookingController::class, 'create'])->name('listbooks.create');
            Route::post('/books/store', [BookingController::class, 'store'])->name('listbooks.store');
            //Route::put('/books/edit/{id}', [BookingController::class, 'edit'])->name('listbooks.edit');
            //Route::patch('/books/update/{id}', [BookingController::class, 'update'])->name('listbooks.update');
            //Route::delete('/books/destroy/{id}', [BookingController::class, 'destroy'])->name('listbooks
            //.destroy');



            Route::get('/setup', function () {
                $credentials = [
                    'email' => 'admin@silkwaytravel.kg',
                    'password' => 'silkway123',
                ];

                if (Auth::attempt($credentials)) {
                    $user = Auth::user();
                    $user->name = 'Администрация';
                    $user->email = 'admin@silkwaytravel.kg';
                    $user->password = Hash::make($credentials['password']);
                    $user->save();

                    if(Auth::attempt($credentials)) {
                        $user = Auth::user();
                        $adminToken = $user->createToken('adminToken', ['create', 'update', 'delete']);
                        $updateToken = $user->createToken('updateToken', ['update', 'delete']);
                        $basicToken = $user->createToken('basicToken');

                        return [
                            'admin' => $adminToken->plainTextToken,
                            'update' => $updateToken->plainTextToken,
                            'basic' => $basicToken->plainTextToken,
                        ];
                    }
                }
            });


        });

        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    require __DIR__ . '/auth.php';


    Route::get('/', [PageController::class, 'index'])->name('index');
    Route::get('/allrooms', [PageController::class,'allrooms'])->name('allrooms');

    Route::get('/products/create-step-one', [PageController::class, 'createStepOne'])->name('createStepOne');
    Route::post('/products/create-step-one', [PageController::class, 'postCreateStepOne'])->name('postCreateStepOne');
    Route::get('/products/create-step-two', [PageController::class, 'createStepTwo'])->name('createStepTwo');
    Route::post('/products/create-step-two', [PageController::class, 'postCreateStepTwo'])->name('postCreateStepTwo');
    Route::get('/products/create-step-three', [PageController::class, 'createStepThree'])->name('createStepThree');
    Route::post('/products/create-step-three', [PageController::class, 'postCreateStepThree'])->name('postCreateStepThree');

    //exely API
    Route::get('/properties', [PageController::class, 'properties'])->name('properties');
    Route::get('/properties/{property}', [PageController::class, 'property'])->name('property');
    Route::get('/meals', [PageController::class, 'meals'])->name('meals');
    Route::get('/roomtypes', [PageController::class, 'roomtypes'])->name('roomtypes');
    Route::get('/amenities', [PageController::class, 'amenities'])->name('amenities');
    Route::get('/extrarules', [PageController::class, 'extrarules'])->name('extrarules');
    Route::get('/searchProperty', [PageController::class, 'searchProperty'])->name('searchProperty');


    Route::get('/allhotels', [PageController::class, 'hotels'])->name('hotels');
    Route::get('/about', [PageController::class, 'about'])->name('about');
    Route::get('/contactspage', [PageController::class, 'contactspage'])->name('contactspage');
    Route::get('/search', [PageController::class, 'search'])->name('search');
    Route::get('/{hotel}', [PageController::class, 'hotel'])->name('hotel');
    Route::get('/{hotel}/{rooms}', [PageController::class, 'room'])->name('room');

    //email
    Route::post('contact_mail', [MainController::class, 'contact_mail'])->name('contact_mail');
    Route::post('book_mail', [MainController::class, 'book_mail'])->name('book_mail');


});

