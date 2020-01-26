@extends('loan.master')
@section('title','Loan')
@section('content')
<div class="container">
  <h1 class="" align="left">Edit Loan</h3>
  @if(count($errors) > 0)
  <div class="alert alert-danger">
    <ul>
      @foreach($errors->all() as $error)
      <li>{{$error}}</li>
      @endforeach
    </ul>
  </div>
  @endif

  @if(\Session::has('success'))
  <div class="alert alert-success">
    <p>{{ \Session::get('success') }}</p>
  </div>
  @endif
    <form class="" action="{{action('LoanController@update', $id)}}" method="post">
      {{csrf_field()}}
      <div class="input-group mb-3 ">
        <label for="staticEmail" class="col-sm-2 col-form-label">Loan Amount:</label>
        <div class="col-xs-2">
        <input type="text" class="form-control" name="amount" value="{{$loans->amount}}">
        </div>
        <div class="input-group-prepend">
          <span class="input-group-text" id="basic-addon1">฿</span>
        </div>
      </div>
      <div class="input-group mb-3">
        <label for="staticEmail" class="col-sm-2 col-form-label">Loan Term:</label>
        <div class="col-xs-2">
        <input type="text" class="form-control" name="term" value="{{$loans->term}}">
        </div>
        <div class="input-group-prepend">
          <span class="input-group-text" id="basic-addon1">Years</span>
        </div>
      </div>
      <div class="input-group mb-3">
        <label for="staticEmail" class="col-sm-2 col-form-label">Interest Rate:</label>
        <div class="col-xs-2">
        <input type="text" class="form-control" name="rate" value="{{$loans->rate}}">
        </div>
        <div class="input-group-prepend">
          <span class="input-group-text" id="basic-addon1">%</span>
        </div>
      </div>
      <div class="input-group mb-1">
        <label for="staticEmail" class="col-sm-2 col-form-label">Start Date:</label>
        <div class="col-xs-2">
        <select class="custom-select my-1 mr-sm-2" id="inlineFormCustomSelectPref" name="month">
          <?php
          $sub_month = date('m', strtotime($loans->start_date));
          $sub_year = date('Y', strtotime($loans->start_date));
          $current_month = (int)$sub_month;
          for ($m=1; $m<=12; $m++) {
            $month = date('M', mktime(0,0,0,$m, 1, date('Y')));
            $selected = ($m == $current_month) ? 'selected' : '';
            echo '<option value="'.$m.'" '. $selected .'>'.$month.'</option>';
          }
          ?>
         </select>
         </div>
         <div class="col-xs-2">
         <select class="custom-select my-1 mr-sm-1 " id="inlineFormCustomSelectPref" name="year">
           <?php
           $current_year = (int)$sub_year;
           for ($m=-3; $m<=30; $m++) {
             $years = date("Y");
             $years = $years + $m;
             $selected = ($years == $current_year) ? 'selected' : '';
             echo '<option value="'.$years.'" '. $selected .'>'.$years.'</option>';
           }
           ?>
         </select>
         </div>
      </div>
      <div class="">
        <button type="submit" class="btn btn-primary mb-2">Update</button>
        <a href="{{url('loan')}}" ><button type="button" class="btn btn-secondary mb-2" name="button">Back</button></a>
      </div>
      <input type="hidden" name="_method" value="PATCH">
    </form>

</div>
@endsection
