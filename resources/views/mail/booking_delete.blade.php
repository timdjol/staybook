<table>
    <tr>
        <td>Booking "{{ $book->title }}" deleted by user
            "{{\Illuminate\Support\Facades\Auth::user()->name }}"</td>
    </tr>
</table>

<style>
    table{
        width: 100%;
    }
    table td{
        padding: 10px;
        border-top: 1px solid #ddd;
    }
</style>