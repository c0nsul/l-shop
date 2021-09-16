@extends('auth.layouts.master')

@section('title', 'Заказы')

@section('content')
    <div class="col-md-12">
        <h1>Orders</h1>
        @if(isset($orders) && count($orders)>0)
        <table class="table">
            <tbody>
            <tr>
                <th>
                    #
                </th>
                <th>
                    Name
                </th>
                <th>
                    Phone
                </th>
                <th>
                    Sent time
                </th>
                <th>
                    Total
                </th>
                <th>
                    Actions
                </th>
            </tr>
            @foreach($orders as $order)
                <tr>
                    <td>{{ $order->id}}</td>
                    <td>{{ $order->name }}</td>
                    <td>{{ $order->phone }}</td>
                    <td>{{ $order->created_at->format('H:i d/m/Y') }}</td>
                    <td>{{ $order->calculateFullSum() }} rub.</td>
                    <td>
                        <div class="btn-group" role="group">
                            <a class="btn btn-success" type="button"

                               @admin
                                    href="{{route("show", $order->id)}}"
                               @else
                                    href="{{route("person.orders.show", $order->id)}}"
                               @endadmin

                            >Open</a>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
            {{$orders->links()}}
        @else
            No new orders!
        @endif
    </div>
@endsection
