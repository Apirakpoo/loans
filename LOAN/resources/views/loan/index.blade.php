@extends('loan.master')
@section('title','Loan')
@section('content')

<div class="container">
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
  <h1 class="" align="left">All Loan</h1>
  <div class="form-group">
  <div class="btn-toolbar justify-content-between" role="toolbar" aria-label="Toolbar with button groups">
    <a href="{{url('loan/create')}}" class="btn btn-primary" >Add New Loan </a>
    <button type="button" name="button" onclick="myFunction()">Advanced Search</button>
  </div>
</div>
<style>

</style>
<?php
  $lm_min  = isset($_GET['lm_min']) ? $_GET['lm_min'] : '';
  $lm_max  = isset($_GET['lm_max']) ? $_GET['lm_max'] : '';
  $ir_min  = isset($_GET['ir_min']) ? $_GET['ir_min'] : '';
  $ir_max  = isset($_GET['ir_max']) ? $_GET['ir_max'] : '';
 ?>
<div id="myDIV" style="display: none">
<form class="" action="/search" method="get">
  <div class="mb-3 border">
    <div class="card-header">
      Advanced Search
    </div>

    <div class="input-group">
      <label for="inputEmail3" class="ml-3 col-form-label font-weight-bold">Loan Amount(THB):</label>
    </div>
    <div class="input-group">
      <label for="inputEmail3" class="ml-3 col-form-label">Min:</label>
      <input type="text" class="form-control ml-2" name="lm_min" id="lm_min" value="<?php echo $lm_min ?>">
      <label for="inputEmail3" class="ml-2 col-form-label">Max:</label>
      <input type="text" class="form-control ml-2" name="lm_max" id="lm_max" value="<?php echo $lm_max ?>">
    </div>
    <div class="input-group">
      <label for="inputEmail3" class="ml-3 col-form-label font-weight-bold">Interest Rate(%):</label>
    </div>
    <div class="input-group mb-4">
      <label for="inputEmail3" class="ml-3 col-form-label">Min:</label>
      <input type="text" class="form-control ml-2" name="ir_min" id="ir_min" value="<?php echo $ir_min ?>">
      <label for="inputEmail3" class="ml-2 col-form-label">Max:</label>
      <input type="text" class="form-control ml-2" name="ir_max" id="ir_max" value="<?php echo $ir_max ?>">
    </div>

    <div class="form-group ml-4">
    <button type="submit" class="btn btn-primary">Search</button>
    <a href="{{url('loan')}}" class="btn btn-secondary">Show All</a>
    </div>
  </div>
</form>
</div>

  <table class="table table-striped">
    <thead>
      <tr>
        <th scope="col">ID</th>
        <th scope="col">Loan Amount</th>
        <th scope="col">Loan Term</th>
        <th scope="col">Interest Rate</th>
        <th scope="col">Created at </th>
        <th scope="col">Action</th>
      </tr>
    </thead>
    <tbody>
      @foreach($loans as $key => $row)
      <tr>
        <td>{{$row['id']}}</td>
        <td>{{ number_format($row['amount'],2) }} ฿</td>
        <td>{{$row['term']}} Years</td>
        <td>{{$row['rate']}} %</td>
        <td>{{$row['created_at']}}</td>
        <td>

          <div class="form-row">
          <div class="col-3">
          <a href="{{action('LoanController@show',$row['id'])}}" class="btn btn-info">View</a>
          </div>
          <div class="col-3">
          <a href="{{action('LoanController@edit',$row['id'])}}" class="btn btn-success">Edit</a>
          </div>
          <form class="delete_form" action="{{action('LoanController@destroy',$row['id'])}}" method="post">
            {{csrf_field()}}
            <input type="hidden" name="_method" value="DELETE">
            <input type="submit" class="btn btn-danger" name="" value="Delete">
          </form>
          </div>

        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
<script type="text/javascript">
  $(function(){
    $('.delete_form').on('submit', function(){
      if(confirm('Confirm.')){
        return true;
      }else{
        return false;
      }
    });

    if( $('#lm_min').val() != '' || $('#lm_max').val() != '' || $('#ir_min').val() != '' || $('#ir_max').val() != '' ){
      $('#myDIV').css('display','block');
    }
  });

  function myFunction() {
    var x = document.getElementById("myDIV");
    if (x.style.display === "none") {
      x.style.display = "block";
    } else {
      x.style.display = "none";
    }
  }
</script>
@endsection
