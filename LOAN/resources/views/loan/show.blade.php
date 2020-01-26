@extends('loan.master')
@section('title','Loan')
@section('content')
<div class="container">
  <h2 class="mb-3" align="left">Loan Details</h2>
    <div class="input-group mb-1 ">
      <div class="col-sm-2">
        ID:
      </div>
      {{$loans->id}}
    </div>
    <div class="input-group mb-1 ">
      <div class="col-sm-2">
        Loan Amount:
      </div>
      {{number_format($loans->amount,2)}} ฿
    </div>
    <div class="input-group mb-1 ">
      <div class="col-sm-2">
        Loan Term:
      </div>
      {{$loans->term}} Years
    </div>
    <div class="input-group mb-1 ">
      <div class="col-sm-2">
        Loan Rate:
      </div>
      {{number_format((($loans->term / $loans->rate)*100),2)}} %
    </div>
    <div class="input-group mb-4 ">
      <div class="col-sm-2">
        Create at:
      </div>
      {{$loans->created_at}}
    </div>

    <?php

    function date_run($date,$num){
      $ts1 = strtotime($date);
      $month = date('m', $ts1);
      $year = date('y', $ts1);
      $day = date('d', $ts1);
      return date("M Y", mktime(0,0,0, $month + $num,$day, $year));
    }

    function get_end_date($d,$num){
      $ts1 = strtotime($d);
      $year = date('y', $ts1);
      $month = date('m', $ts1);
      $day = date('d', $ts1);
      return date("Y-m-d", mktime(0,0,0, $month, $day, $year + $num));
    }

    function get_month_diff($start, $end = FALSE)
    {
      $start = new DateTime($start);
      $end   = new DateTime($end);
      $diff  = $start->diff($end);
      return $diff->format('%y') * 12 + $diff->format('%m');

    }

    function get_pmt($p,$r,$y){
      $res = ( $p * ( $r / 12) ) / ( 1 - ( pow(( 1+( $r / 12 )),(-1*( 12 * $y ))) ) );
      return $res;
    }
    $interest_per_year = $loans->term / $loans->rate;
    $end_date = get_end_date($loans->start_date, 1);
    $cnt_month = 12 * $loans->term;
    $pmt = get_pmt($loans->amount,$interest_per_year,$loans->term);
    ?>

    <div class="input-group mb-3 ">
      <a href="{{url('loan')}}" ><button type="button" class="" name="button">Back</button></a>
    </div>

    <h2 class="mb-3" align="left">Repayment Schedules</h2>

    <table class="table table-striped">
      <thead>
        <tr>
          <th scope="col">Payment No</th>
          <th scope="col">Date</th>
          <th scope="col">Payment Amount</th>
          <th scope="col">Principal</th>
          <th scope="col">Interest</th>
          <th scope="col">Balance</th>
        </tr>
      </thead>
      <tbody>
        <?php
          $balance = $loans->amount;
          for($i=0;$i<$cnt_month;$i++){
            $interest = ($interest_per_year / 12) * $balance;
            $principal = $pmt - $interest;
            $balance = $balance - $principal;
        ?>
          <tr>
            <td>{{$i+1}}</td>
            <td><?php echo date_run($loans->start_date, ($i+1)); ?></td>
            <td><?php echo number_format($pmt,2) ?></td>
            <td><?php echo number_format($principal,2) ?></td>
            <td><?php echo number_format($interest,2) ?></td>
            <td><?php echo number_format($balance,2) ?></td>
          </tr>
          <?php  } ?>
      </tbody>
    </table>
    <a href="{{url('loan')}}" ><button type="button" class="" name="button">Back</button></a>
</div>
@endsection
