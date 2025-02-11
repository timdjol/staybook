<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ApiController extends Controller
{
    //exely api
    public function properties()
    {
        $response = Http::withHeaders(['x-api-key' => 'fd54fc5c-2927-4998-8132-fb1107fc81c4', 'accept' => 'application/json'])->get('https://connect.test.hopenapi.com/api/content/v1/properties?count=20&include=All');
        $properties = $response->object()->properties;

        return view('pages.exely.properties', compact('properties'));
    }

    public function property($property)
    {

        $response = Http::withHeaders(['x-api-key' => 'fd54fc5c-2927-4998-8132-fb1107fc81c4', 'accept' => 'application/json'])->get('https://connect.test.hopenapi.com/api/content/v1/properties/' . $property);
        $property = $response->object();

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

        return view('pages.exely.extrarules', compact('rules'));
    }

    //Search API
    public function search_property(Request $request)
    {
        $response = Http::accept('application/json')->withHeaders(['x-api-key' => 'fd54fc5c-2927-4998-8132-fb1107fc81c4'])->post('https://connect.test.hopenapi.com/api/search/v1/properties/room-stays/search', [
            "propertyIds" => ["500803", "500804"],
            "adults" => 1,
            //"childAges" => [1],
            "include" => "",
            "arrivalDate" => "2025-03-01",
            "departureDate" => "2025-05-30",
            "mealPreference" => [
                "mealType" => "MealOnly",
                "mealsIncluded" => ["mealPlanCodes" => ["BreakFast"]],
            ],
            "pricePreference" => [
                "currencyCode" => "GBP",
                "minPrice" => 50,
                "maxPrice" => 100000,
            ],
            //"corporateCodes" => ["string"],
        ]);
        $rules = $response->json();
        dd($rules);
        return view('pages.exely.search', compact('rules'));
    }

    public function search_roomstays()
    {
        $response = Http::withHeaders(['x-api-key' => 'fd54fc5c-2927-4998-8132-fb1107fc81c4', 'accept' => 'application/json'])->get('https://connect.test.hopenapi.com/api/search/v1/properties/500803/room-stays?arrivalDate=2025-03-10&departureDate=2025-03-11&adults=1&includeExtraStays=false&includeExtraServices=false
');
        $rooms = $response->object()->roomStays;

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
        //dd($services);

        return view('pages.exely.search-services', compact('services'));
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
    public function res_bookings()
    {
        $response = Http::withHeaders(['x-api-key' => 'fd54fc5c-2927-4998-8132-fb1107fc81c4', 'accept' => 'application/json'])->post('https://connect.test.hopenapi.com/api/search/v1/bookings', [
            "booking" => [
                "propertyId" => "500803",
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
                        "services" => [
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
                "services" => [["id" => "7898"]],
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
                "createBookingToken" => "QUNERjMyQjctNTQyNi00NTdELTk0QzItQTU0Mjc0QTY0RThD",
            ],
        ]);

        $bookings = $response->object();
        dd($bookings);
    }

    public function res_booking()
    {
        $response = Http::withHeaders(['x-api-key' => 'fd54fc5c-2927-4998-8132-fb1107fc81c4', 'accept' => 'application/json'])->post('https://connect.test.hopenapi.com/api/reservation/v1/bookings/20191001-1024-45675262');
        $booking = $response->json();
        //dd($booking);
    }

    public function res_modify()
    {
        $response = Http::withHeaders(['x-api-key' => 'fd54fc5c-2927-4998-8132-fb1107fc81c4', 'accept' => 'application/json'])->get('https://connect.test.hopenapi.com/api/reservation/v1/bookings/20191001-1024-45675262/modify', [
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
                        "services" => [
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
                "services" => [["id" => "7898"]],
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
        $booking = $response->object();
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
                        "services" => [
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
                "services" => [["id" => "7898"]],
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
        $booking = $response->object();
        dd($booking);


    }

    public function res_cancel()
    {
        $response = Http::withHeaders(['x-api-key' => 'fd54fc5c-2927-4998-8132-fb1107fc81c4', 'accept' => 'application/json'])->post('https://connect.test.hopenapi.com/api/reservation/v1/bookings/20191001-1024-45675262/cancel', [
            "reason" => "Booking cancellation",
            "expectedPenaltyAmount" => 0
        ]);
        $rules = $response->object();
        dd($rules);

        return view('pages.exely.extrarules', compact('rules'));
    }

    public function res_calculate()
    {
        $response = Http::withHeaders(['x-api-key' => 'fd54fc5c-2927-4998-8132-fb1107fc81c4', 'accept' => 'application/json'])->get('https://connect.test.hopenapi.com/api/reservation/v1/bookings/20191001-1024-45675262/calculate-cancellation-penalty?cancellationDateTimeUtc=2025-02-11T14%3A00%3A00Z');
        $calc = $response->object();

        dd($calc);
    }

    public function res_verify_bookings()
    {
        $response = Http::withHeaders(['x-api-key' => 'fd54fc5c-2927-4998-8132-fb1107fc81c4', 'accept' => 'application/json'])->post('https://connect.test.hopenapi.com/api/reservation/v1/bookings/verify', [
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
                        "services" => [
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
                "services" => [["id" => "7898"]],
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
            ],
        ]);

        $calc = $response->object();

        dd($calc);
    }
}
