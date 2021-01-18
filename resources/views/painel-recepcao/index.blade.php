@extends('template.template-recep')
@section('title', 'Recepção')
@section('content')
<?php 
@session_start();
if(@$_SESSION['level_user'] != 'recep'){ 
  echo "<script language='javascript'> window.location='./' </script>";
}
?>
Home Recepção
@endsection