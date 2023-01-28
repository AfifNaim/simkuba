<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Laporan Keuangan</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>

  <center>
    <h4>LAPORAN KEUANGAN</h4>
  </center>

  <table style="width: 40%">
    <tr>
      <td width="30%">DARI TANGGAL</td>
      <td width="5%" class="text-center">:</td>
      <td>{{ date('d-m-Y',strtotime($_GET['from'])) }}</td>
    </tr>
    <tr>
      <td width="30%">SAMPAI TANGGAL</td>
      <td width="5%" class="text-center">:</td>
      <td>{{ date('d-m-Y',strtotime($_GET['to'])) }}</td>
    </tr>
    <tr>
      <td width="30%">KATEGORI</td>
      <td width="5%" class="text-center">:</td>
      <td>
      @php
        $category_id = $_GET['categories'];
        @endphp

        @if($category_id == "")
        @php
        $categoryAll = "SEMUA KATEGORI";
        @endphp
        @else
        @php
        $getCategory = DB::table('categories')->where('id',$category_id)->first();
        $categoryAll = $getCategory->name
        @endphp
        @endif

        {{$categoryAll}}
      </td>
    </tr>
    <tr>
      <td>UMKM</td>
      <td>:</td>
      <td>{{ $company->name }}</td>
    </tr>
    <tr>
      <td>ALAMAT</td>
      <td>:</td>
      <td>{{ $company->address }}</td>
    </tr>
  </table>

  <br>

  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th rowspan="2" class="text-center" width="1%">NO</th>
        <th rowspan="2" class="text-center" width="9%">TANGGAL</th>
        <th rowspan="2" class="text-center">KATEGORI</th>
        <th rowspan="2" class="text-center">KETERANGAN</th>
        <th colspan="2" class="text-center">JENIS</th>
      </tr>
      <tr>
        <th class="text-center">PEMASUKAN</th>
        <th class="text-center">PENGELUARAN</th>
      </tr>
    </thead>
    <tbody>
      @php
      $number = 1;
      $sumIncome = 0;
      $sumExpense = 0;
      @endphp
      @foreach($cashbooks as $cashbook)
      <tr>
        <td class="text-center">{{ $number++ }}</td>
        <td class="text-center">{{ date('d-m-Y', strtotime($cashbook->date )) }}</td>
        <td>{{ $cashbook->category->name }}</td>
        <td>{{ $cashbook->description }}</td>
        <td class="text-center">
          @if($cashbook->type == "K")
          {{ "Rp.".number_format($cashbook->amount).",-" }}
          @php $sumIncome += $cashbook->amount; @endphp
          @else
          {{ "-" }}
          @endif
        </td>
        <td class="text-center">
          @if($cashbook->type == "M")
          {{ "Rp.".number_format($cashbook->amount).",-" }}
          @php $sumIncome += $cashbook->amount; @endphp
          @else
          {{ "-" }}
          @endif
        </td>
      </tr>
      @endforeach
    </tbody>
    <tfoot>
      <tr>
        <td colspan="4" class="text-bold text-right">TOTAL</td>
        <td class="text-center">{{ "Rp.".number_format($sumIncome).",-" }}</td>
        <td class="text-center">{{ "Rp.".number_format($sumExpense).",-" }}</td>
      </tr>
    </tfoot>
  </table>

  <table style="width: 40%">
  <tr>
    <td>Report Created</td>
    <td>:</td>
    <td>{{ date('Y-m-d H:i:s') }}</td>
  </tr>
  </table>

  <script type="text/javascript">
    window.print();
  </script>

</body>
</html>
