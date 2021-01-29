@extends('template.template-atend')
@section('title', 'Comissões')
@section('content')
<?php 
@session_start();
if(@$_SESSION['level_user'] != 'atend'){ 
  echo "<script language='javascript'> window.location='./' </script>";
}
?>
<!-- DataTales Example -->
<div class="card shadow mb-4">
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
          <th>Descrição</th>
          <th>Data</th>
          <th>Valor</th>
          </tr>
        </thead>
        <tbody>
            @foreach($itens as $item)
             <?php
              $value = implode(',', explode('.', $item->value));
              $data = implode('/', array_reverse(explode('-', $item->data)));
             ?>
              <tr>
                <td>{{$item->descricao}}</td>
                <td>{{$data}}</td>
                <td>{{$value}}</td>
              </tr>
            @endforeach 
        </tbody>
      </table>
    </div>
  </div>
</div>
<script type="text/javascript">
  $(document).ready(function () {
    $('#dataTable').dataTable({
      "ordering": false
    })
  });
</script>
@endsection