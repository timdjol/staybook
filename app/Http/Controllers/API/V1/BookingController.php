<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\CancelRequest;
use App\Http\Requests\API\V1\StoreBookRequest;
use App\Http\Resources\V1\BookingResource;
use App\Models\Book;
use App\Models\Room;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;


class BookingController extends Controller
{
    /**
     * @return Collection
     */
    public function index()
    {
        return BookingResource::collection(Book::all());
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function show($id)
    {
        try {
            $book = Book::where('status', '!=', 'Отменен пользователем')->findOrFail($id);
            return response()->json($book);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Book not found'], 404);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function store(StoreBookRequest $request)
    {
        $params = $request->validated();
        $booking = Book::create($params);
        $room = Room::where('id', $request->room_id)->firstOrFail();
        $room->decrement('count', $request->count);

        return response()->json($booking);
        //return redirect()->route('books.index', $room->id);
    }

    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function update(StoreBookRequest $request, $id)
    {
        $booking = Book::findOrFail($id);
        if (!$booking) {
            return response()->json([
                'error' => 'Unable to booking'
            ], 404);
        }
        $booking->update($request->validated());
        return response()->json('Book updated');
    }

    /**
     * @param Request $request
     * @return JsonResponse|RedirectResponse
     */
    public function cancel(CancelRequest $request)
    {
        $book_token = $request->book_token;
        //$id = $request->book_id;
        try {
            $book = Book::where('book_token', $book_token)->where('status', '!=', 'Отменен пользователем')->first();
            $book->update(['status' => 'Отменен пользователем']);
            return response()->json('Book cancelled');
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Book not found'], 404);
        }

    }
}
