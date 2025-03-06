<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ExelyController extends Controller
{
    //exely api
    public function properties()
    {
        $response = Http::withHeaders(['x-api-key' => 'fd54fc5c-2927-4998-8132-fb1107fc81c4', 'accept' => 'application/json'])->get('https://connect.test.hopenapi.com/api/content/v1/properties?count=20&include=All');
        $properties = $response->object()->properties;
        //dd($properties);
        $res = Http::withHeaders(['x-api-key' => 'fd54fc5c-2927-4998-8132-fb1107fc81c4', 'accept' => 'application/json'])->get('https://connect.test.hopenapi.com/api/content/v1/properties?count=20&include=All');
        $hotels = $res->object()->properties;
        //dd($hotels);
        return view('pages.exely.properties', compact('properties', 'hotels'));
    }

    public function property($property)
    {
        $response = Http::withHeaders(['x-api-key' => 'fd54fc5c-2927-4998-8132-fb1107fc81c4', 'accept' => 'application/json'])->get('https://connect.test.hopenapi.com/api/content/v1/properties/' . $property);
        $property = $response->object();
        //dd($property);

        return view('pages.exely.property', compact('property'));
    }

    public function meals()
    {
        $response = Http::withHeaders(['x-api-key' => 'fd54fc5c-2927-4998-8132-fb1107fc81c4', 'accept' => 'application/json'])->get('https://connect.test.hopenapi.com/api/content/v1/meal-plans');
        $meals = $response->object();

        return view('pages.exely.meals', compact('meals'));
    }

    public function roomtypes()
    {
        $response = Http::withHeaders(['x-api-key' => 'fd54fc5c-2927-4998-8132-fb1107fc81c4', 'accept' => 'application/json'])->get('https://connect.test.hopenapi.com/api/content/v1/room-type-categories');
        $types = $response->object();

        return view('pages.exely.roomtypes', compact('types'));
    }

    public function amenities()
    {
        $response = Http::withHeaders(['x-api-key' => 'fd54fc5c-2927-4998-8132-fb1107fc81c4', 'accept' => 'application/json'])->get('https://connect.test.hopenapi.com/api/content/v1/room-amenity-categories');
        $amenities = $response->object();

        return view('pages.exely.amentities', compact('amenities'));
    }

    public function extrarules()
    {
        $response = Http::withHeaders(['x-api-key' => 'fd54fc5c-2927-4998-8132-fb1107fc81c4', 'accept' => 'application/json'])->get('https://connect.test.hopenapi.com/api/content/v1/properties/500803/extra-stay-rules');
        $rules = $response->object()->extraStayRules;
        dd($rules);

        return view('pages.exely.extrarules', compact('rules'));
    }

    //Search API
    public function search_property(Request $request)
    {
        //dd($request->all());
        $response = Http::accept('application/json')->withHeaders(['x-api-key' => 'fd54fc5c-2927-4998-8132-fb1107fc81c4'])->post('https://connect.test.hopenapi.com/api/search/v1/properties/room-stays/search', [
            "propertyIds" => [$request->title],
            "adults" => $request->adult,
            "childAges" => [$request->age1, $request->age2, $request->age3],
            "include" => "",
            "arrivalDate" => $request->arrivalDate,
            "departureDate" => $request->departureDate,
//            "mealPreference" => [
//                "mealType" => "MealOnly",
//                "mealsIncluded" => ["mealPlanCodes" => ["BreakFast"]],
//            ],
//            "pricePreference" => [
//                "currencyCode" => "USD",
//                "minPrice" => 0,
//                "maxPrice" => 10000,
//            ],
            //"corporateCodes" => ["string"],
        ]);
        $results = $response->object();

        return view('pages.exely.search', compact('results'));
    }

    public function search_roomstays(Request $request)
    {
        $response = Http::withHeaders(['x-api-key' => 'fd54fc5c-2927-4998-8132-fb1107fc81c4', 'accept' => 'application/json'])
            ->get('https://connect.test.hopenapi.com/api/search/v1/properties/'.$request->title.'/room-stays?arrivalDate='.$request->arrivalDate.'&departureDate='.$request->departureDate.'&adults='.$request->adults.'&includeExtraStays=false&includeExtraServices=false
');
        $rooms = $response->object()->roomStays;
        $rooms = collect($rooms)->sortBy('total')->values()->all();


        return view('pages.exely.search-roomstays', compact('rooms'));
    }


    public function search_services(Request $request)
    {
        $response = Http::accept('application/json')->withHeaders(['x-api-key' => 'fd54fc5c-2927-4998-8132-fb1107fc81c4'])->post('https://connect.test.hopenapi.com/api/search/v1/properties/500803/services', [
            "stayDates" => [
                "arrivalDateTime" => "2025-03-07T14:00",
                "departureDateTime" => "2025-03-08T12:00",
            ],
            "roomType" => ["id" => "82751", "placements" => [["code" => "AdultBed-2"]]],
            "ratePlan" => ["id" => "987657", "corporateCodes" => ["string"]],
            "guestCount" => ["adultCount" => 1, "childAges" => [2]],
        ]);
        $services = $response->object();
        //dd($amenities);

        return view('pages.exely.search-amenities', compact('services'));
    }


    public function search_extrastays()
    {
        $response = Http::withHeaders(['x-api-key' => 'fd54fc5c-2927-4998-8132-fb1107fc81c4', 'accept' => 'application/json'])->post('https://connect.test.hopenapi.com/api/search/v1/properties/500803/extra-stays',
            [
                "stayDates" => [
                    "arrivalDateTime" => "2025-03-10T14:00",
                    "departureDateTime" => "2025-03-11T12:00",
                ],
                "roomType" => ["id" => "82751", "placements" => [["code" => "AdultBed-2"]]],
                "ratePlan" => ["id" => "987657", "corporateCodes" => ["string"]],
                "guestCount" => ["adultCount" => 1, "childAges" => [5]
                ],]);
        $stays = $response->object();
        //dd($stays);

        return view('pages.exely.search-extrastays', compact('stays'));
    }

    //Reservation API

    public function res_verify_bookings(Request $request)
    {
        $response = Http::withHeaders(['x-api-key' => 'fd54fc5c-2927-4998-8132-fb1107fc81c4', 'accept' => 'application/json'])->post('https://connect.test.hopenapi.com/api/reservation/v1/bookings/verify', [
            "booking" => [
                "propertyId" => $request->get("propertyId"),
                "roomStays" => [
                    [
                        "stayDates" => [
                            "arrivalDateTime" => $request->get("arrivalDate"),
                            "departureDateTime" => $request->get("departureDate"),
                        ],
                        "ratePlan" => [
                            "id" => $request->get("ratePlanId"),
                        ],
                        "roomType" => [
                            "placements" => [
                                [
                                    "code" => $request->get("placementCode"),
                                    "count" => $request->get("roomCount"),
                                    "kind" => $request->get("roomType"),
                                    "minAge" => null,
                                    "maxAge" => null
                                ]
                            ],
                            "id" => $request->get("roomTypeId"),
                        ],
                        "guests" => [
                            [
                                "firstName" => $request->get("name"),
                                "lastName" => $request->get("name"),
                                "middleName" => $request->get("name"),
                                "citizenship" => "KGS",
                                "sex" => "Male"
                            ]
                        ],
                        "guestCount" => [
                            "adultCount" => $request->get("guestCount"),
                            "childAges" => [
                            ]
                        ],
                        "amenities" => [
                        ],
                        "checksum" => $request->get("checkSum"),
                    ]
                ],
                "amenities" => [
                ],
                "customer" => [
                    "firstName" => $request->get("name"),
                    "lastName" => $request->get("name"),
                    "middleName" => "",
                    "citizenship" => "",
                    "contacts" => [
                        "phones" => [
                            [
                                "phoneNumber" => $request->get("phone"),
                            ]
                        ],
                        "emails" => [
                            [
                                "emailAddress" => $request->get("email"),
                            ]
                        ]
                    ],
                    "comment" => $request->get("comment"),
                ],
                "prepayment" => [
                    "remark" => null,
                    "paymentType" => null,
                    "prepaidSum" => 0
                ],
                "bookingComments" => [
                    $request->get("comment"),
                ]
            ]
        ]);
        $order = $response->object();

        return view('pages.exely.order-verify', compact('order'));
    }


    public function res_bookings(Request $request)
    {
        //dd($request->all());
        $response = Http::withHeaders(['x-api-key' => 'fd54fc5c-2927-4998-8132-fb1107fc81c4', 'accept' => 'application/json'])->post('https://connect.test.hopenapi.com/api/reservation/v1/bookings', [
            "booking" => [
                "propertyId" => $request->get("propertyId"),
                "roomStays" => [
                    [
                        "stayDates" => [
                            "arrivalDateTime" => $request->get("arrivalDate"),
                            "departureDateTime" => $request->get("departureDate"),
                        ],
                        "ratePlan" => [
                            "id" => $request->get("ratePlanId"),
                            "name" => "Online booking",
                            "description" => "",
//                            "vat" => [
//                                "applicable" => true,
//                                "included" => true,
//                                "percent" => 20
//                            ]
                        ],
                        "roomType" => [
                            "id" => $request->get("roomTypeId"),
                            "placements" => [
                                [
                                    "code" => $request->get("roomCode"),
                                    //"count" => 2,
//                                    "kind" => "Adult",
//                                    "minAge" => null,
//                                    "maxAge" => null
                                ]
                            ],
                            //"name" => "Standard"
                        ],
                        "guests" => [
                            [
                                "firstName" => $request->get("firstName"),
                                "lastName" => $request->get("lastName"),
                                "middleName" => "",
                                "citizenship" => "",
                                "sex" => $request->get("sex"),
                            ]
                        ],
                        "guestCount" => [
                            "adultCount" => $request->get("guestCount"),
                            "childAges" => [

                            ]
                        ],
                        "checksum" => $request->get("checkSum"),
//                        "dailyRates" => [
//                            [
//                                "priceBeforeTax" => 76.47,
//                                "date" => "2025-03-25"
//                            ]
//                        ],
                        "total" => [
                            "priceBeforeTax" => $request->get("priceBeforeTax"),
                            "taxAmount" => 0,
                            "taxes" => [
//                                [
//                                    "amount" => 0.81,
//                                    "index" => 1
//                                ]
                            ]
                        ],
                        "amenities" => [
//                            [
//                                "id" => "42965",
//                                "quantity" => 3,
//                                "name" => "Breakfast",
//                                "description" => "Breakfast at a restaurant at a special price",
//                                "totalPrice" => 9.66,
//                                "serviceTotal" => [
//                                    "priceBeforeTax" => 76.47,
//                                    "taxAmount" => 0.81,
//                                    "taxes" => [
//                                        [
//                                            "amount" => 0.81,
//                                            "index" => 1
//                                        ]
//                                    ]
//                                ],
//                                "inclusive" => false,
//                                "kind" => "Meal",
//                                "mealPlanCode" => "AllInclusive",
//                                "mealPlanName" => "All inclusive",
//                                "vat" => [
//                                    "applicable" => true,
//                                    "included" => true,
//                                    "percent" => 20
//                                ]
//                            ]
                        ],
                        "extraStayCharge" => [
//                            "earlyArrival" => [
//                                "overriddenDateTime" => "2025-03-25T14:00",
//                                "total" => [
//                                    "priceBeforeTax" => 76.47,
//                                    "taxAmount" => 0.81,
//                                    "taxes" => [
//                                        [
//                                            "amount" => 0.81,
//                                            "index" => 1
//                                        ]
//                                    ]
//                                ]
//                            ],
//                            "lateDeparture" => [
//                                "overriddenDateTime" => "2025-03-25T14:00",
//                                "total" => [
//                                    "priceBeforeTax" => 76.47,
//                                    "taxAmount" => 0.81,
//                                    "taxes" => [
//                                        [
//                                            "amount" => 0.81,
//                                            "index" => 1
//                                        ]
//                                    ]
//                                ]
//                            ]
                        ]
                    ]
                ],
                "amenities" => [
//                    [
//                        "id" => "7898",
//                        "name" => "Fruit platter",
//                        "description" => "Fruit platter at check-in",
//                        "price" => 200
//                    ]
                ],
                "customer" => [
                    "firstName" => $request->get("firstName"),
                    "lastName" => $request->get("lastName"),
                    "middleName" => "",
                    "citizenship" => "",
                    "contacts" => [
                        "phones" => [
                            [
                                "phoneNumber" => $request->get("phone"),
                            ]
                        ],
                        "emails" => [
                            [
                                "emailAddress" => $request->get("email"),
                            ]
                        ]
                    ],
                    "comment" => $request->get("comment"),
                ],
                "prepayment" => [
                    "remark" => "Payment in channel",
                    "paymentType" => "Cash",
                    "prepaidSum" => 0
                ],
                "bookingComments" => [
                    $request->get("comment"),
                ],
                "total" => [
                    "priceBeforeTax" => $request->get("priceBeforeTax"),
                    "taxAmount" => 0,
                    "taxes" => [
//                        [
//                            "amount" => 0.81,
//                            "index" => 1
//                        ]
                    ]
                ],
                "taxes" => [
//                    [
//                        "index" => 1,
//                        "name" => "Lodging fee",
//                        "description" => "Fee per guest, payable at check-in"
//                    ]
                ],
                "currencyCode" => "EUR",
                "cancellation" => [
                    "penaltyAmount" => $request->get("cancellation"),
                    "reason" => "Booking cancellation",
                    //"cancelledUtc" => "2025-03-25T12:00:00Z"
                ],
                "cancellationPolicy" => [
                    "freeCancellationPossible" => false,
                    "freeCancellationDeadlineLocal" => null,
                    "freeCancellationDeadlineUtc" => null,
                    "penaltyAmount" => $request->get("cancellation"),
                ],
                "createBookingToken" => $request->get("createBookingToken"),
//                "number" => "20191001-1024-45675262",
//                "status" => "Confirmed",
//                "createdDateTime" => "2025-03-25T12:00:00Z",
//                "modifiedDateTime" => "2025-03-25T12:00:00Z",
//                "version" => "MjAyMzA1MTktNzI5Mi0xMTc1MzI1Mi0y"
            ]
        ]);

        $res = $response->object();

        return view('pages.exely.order-booking', compact('res'));
    }

    public function res_booking()
    {
        $response = Http::withHeaders(['x-api-key' => 'fd54fc5c-2927-4998-8132-fb1107fc81c4', 'accept' => 'application/json'])->get('https://connect.test.hopenapi.com/api/reservation/v1/bookings/20191001-1024-45675262');
        $booking = $response->object()->errors[0];
        dd($booking);
    }

    public function res_modify()
    {
        $response = Http::withHeaders(['x-api-key' => 'fd54fc5c-2927-4998-8132-fb1107fc81c4', 'accept' => 'application/json'])->post('https://connect.test.hopenapi.com/api/reservation/v1/bookings/20191001-1024-45675262/modify', [
            "booking" => [
                "propertyId" => "1024",
                "roomStays" => [
                    [
                        "stayDates" => [
                            "arrivalDateTime" => "2025-03-11T14:00",
                            "departureDateTime" => "2025-03-12T12:00",
                        ],
                        "ratePlan" => ["id" => "133528"],
                        "roomType" => [
                            "id" => "82751",
                            "placements" => [["code" => "AdultBed-2"]],
                        ],
                        "guests" => [
                            [
                                "firstName" => "John",
                                "lastName" => "Doe",
                                "middleName" => "Smith",
                                "citizenship" => "GBR",
                                "sex" => "Male",
                            ],
                        ],
                        "guestCount" => ["adultCount" => 1, "childAges" => [5]],
                        "checksum" =>
                            "eyJDaGVja3N1bVdpdGhPdXRFeHRyYXMiOnsiVG90YWxBbW91bnRBZnRlclRheCI6IjU1LjUwIiwiQ3VycmVuY3lDb2RlIjoiR0JQIiwiU3RhcnRQZW5hbHR5QW1vdW50IjoiOS43MiJ9LCJDaGVja3N1bVdpdGhFeHRyYXMiOnsiVG90YWxBbW91bnRBZnRlclRheCI6IjU1LjUwIiwiQ3VycmVuY3lDb2RlIjoiR0JQIiwiU3RhcnRQZW5hbHR5QW1vdW50IjoiOS43MiJ9fQ==",
                        "amenities" => [
                            [
                                "id" => "42965",
                                "quantity" => 3,
                                "quantityByGuests" => null,
                            ],
                        ],
                        "extraStay" => [
                            "earlyArrival" => [
                                "overriddenDateTime" => "2025-03-11T14:00",
                            ],
                            "lateDeparture" => [
                                "overriddenDateTime" => "2025-03-11T14:00",
                            ],
                        ],
                    ],
                ],
                "amenities" => [["id" => "7898"]],
                "customer" => [
                    "firstName" => "John",
                    "lastName" => "Doe",
                    "middleName" => "Smith",
                    "citizenship" => "GBR",
                    "contacts" => [
                        "phones" => [["phoneNumber" => "+442012345678"]],
                        "emails" => [["emailAddress" => "email@example.com"]],
                    ],
                    "comment" => "Preferably a room with a sea view",
                ],
                "prepayment" => [
                    "remark" => "Payment in channel",
                    "paymentType" => "Cash",
                    "prepaidSum" => 0,
                ],
                "bookingComments" => ["Preferably a room with a sea view"],
                "version" => "MjAyMzA1MTktNzI5Mi0xMTc1MzI1Mi0y",
            ],
        ]);
        $booking = $response->object()->errors[0];
        dd($booking);
    }


    public function res_verify()
    {
        $response = Http::withHeaders(['x-api-key' => 'fd54fc5c-2927-4998-8132-fb1107fc81c4', 'accept' => 'application/json'])->post('https://connect.test.hopenapi.com/api/reservation/v1/bookings/20191001-1024-45675262/modify', [
            "booking" => [
                "propertyId" => "1024",
                "roomStays" => [
                    [
                        "stayDates" => [
                            "arrivalDateTime" => "2025-03-11T14:00",
                            "departureDateTime" => "2025-03-12T12:00",
                        ],
                        "ratePlan" => ["id" => "133528"],
                        "roomType" => [
                            "id" => "82751",
                            "placements" => [["code" => "AdultBed-2"]],
                        ],
                        "guests" => [
                            [
                                "firstName" => "John",
                                "lastName" => "Doe",
                                "middleName" => "Smith",
                                "citizenship" => "GBR",
                                "sex" => "Male",
                            ],
                        ],
                        "guestCount" => ["adultCount" => 1, "childAges" => [5]],
                        "checksum" =>
                            "eyJDaGVja3N1bVdpdGhPdXRFeHRyYXMiOnsiVG90YWxBbW91bnRBZnRlclRheCI6IjU1LjUwIiwiQ3VycmVuY3lDb2RlIjoiR0JQIiwiU3RhcnRQZW5hbHR5QW1vdW50IjoiOS43MiJ9LCJDaGVja3N1bVdpdGhFeHRyYXMiOnsiVG90YWxBbW91bnRBZnRlclRheCI6IjU1LjUwIiwiQ3VycmVuY3lDb2RlIjoiR0JQIiwiU3RhcnRQZW5hbHR5QW1vdW50IjoiOS43MiJ9fQ==",
                        "amenities" => [
                            [
                                "id" => "42965",
                                "quantity" => 3,
                                "quantityByGuests" => null,
                            ],
                        ],
                        "extraStay" => [
                            "earlyArrival" => [
                                "overriddenDateTime" => "2025-03-11T14:00",
                            ],
                            "lateDeparture" => [
                                "overriddenDateTime" => "2025-03-11T14:00",
                            ],
                        ],
                    ],
                ],
                "amenities" => [["id" => "7898"]],
                "customer" => [
                    "firstName" => "John",
                    "lastName" => "Doe",
                    "middleName" => "Smith",
                    "citizenship" => "GBR",
                    "contacts" => [
                        "phones" => [["phoneNumber" => "+442012345678"]],
                        "emails" => [["emailAddress" => "email@example.com"]],
                    ],
                    "comment" => "Preferably a room with a sea view",
                ],
                "prepayment" => [
                    "remark" => "Payment in channel",
                    "paymentType" => "Cash",
                    "prepaidSum" => 0,
                ],
                "bookingComments" => ["Preferably a room with a sea view"],
                "version" => "MjAyMzA1MTktNzI5Mi0xMTc1MzI1Mi0y",
            ],
        ]);
        $booking = $response->object()->errors[0];
        dd($booking);


    }

    public function res_cancel()
    {
        $response = Http::withHeaders(['x-api-key' => 'fd54fc5c-2927-4998-8132-fb1107fc81c4', 'accept' => 'application/json'])->post('https://connect.test.hopenapi.com/api/reservation/v1/bookings/20191001-1024-45675262/cancel', [
            "reason" => "Booking cancellation",
            "expectedPenaltyAmount" => 0
        ]);
        $rules = $response->object()->errors[0];
        dd($rules);

        return view('pages.exely.extrarules', compact('rules'));
    }

    public function res_calculate(Request $request)
    {
        $response = Http::withHeaders(['x-api-key' => 'fd54fc5c-2927-4998-8132-fb1107fc81c4', 'accept' => 'application/json'])->get('https://connect.test.hopenapi.com/api/reservation/v1/bookings/'.$request->nummber.'/calculate-cancellation-penalty?cancellationDateTimeUtc='.$request->cancelTime);
        $calc = $response->object();

        dd($calc);
    }


    public function orderexely(Request $request)
    {
        return view('pages.exely.orderexely', compact('request'));
    }

}
