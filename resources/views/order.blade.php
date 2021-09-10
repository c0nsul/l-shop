@extends('layouts.master')

@section('title', 'Оформить заказ')

@section('content')

    <h1>Confirm your order:</h1>
    <div class="container">
        <div class="row justify-content-center">
            <p>Total: <b>{{ isset( $order) ? $order->getFullPrice() : 0 }} rub.</b></p>
            <form action="{{route("basket-confirm")}}" method="POST">
                @csrf
                <div>
                    <p>Please fill your phone and your name and we will contact you asap:</p>

                    <div class="container">
                        <div class="form-group">
                            <label for="name" class="control-label col-lg-offset-3 col-lg-2">Name: </label>
                            <div class="col-lg-4">
                                <input type="text" required name="name" id="name" value="" class="form-control">
                            </div>
                        </div>
                        <br>
                        <br>
                        <div class="form-group">
                            <label for="phone" class="control-label col-lg-offset-3 col-lg-2">Phone: </label>
                            <div class="col-lg-4">
                                <input type="text" required name="phone" id="phone" value="" class="form-control">
                            </div>
                        </div>
                    </div>
                    <br>
                    <input type="submit" class="btn btn-success" value="Confirm">
                </div>
            </form>
        </div>
    </div>

@endsection
