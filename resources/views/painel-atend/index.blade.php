@extends('template.template-default')
@section('title', 'Atendimento')
@section('content')
<?php 
@session_start();
if(@$_SESSION['level_user'] != 'atend'){ 
  echo "<script language='javascript'> window.location='./' </script>";
}
?>
Home Atendimento
@endsection