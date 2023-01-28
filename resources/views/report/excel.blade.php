<!DOCTYPE html>
<html>
<head>
  <title>Laporan Keuangan</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>

  <center>
    <h4>LAPORAN KEUANGAN</h4>
  </center>
  <table>
    <tr>
      <td>DARI TANGGAL</td>
      <td>:</td>
      <td>{{ date('d-m-Y',strtotime($_GET['from'])) }}</td>
    </tr>
    <tr>
      <td>SAMPAI TANGGAL</td>
      <td>:</td>
      <td>{{ date('d-m-Y',strtotime($_GET['to'])) }}</td>
    </tr>
    <tr>
      <td>KATEGORI</td>
      <td>:</td>
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
       <td>{{ $companies->name }}</td>
     </tr>
     <tr>
       <td>Alamat</td>
       <td>:</td>
       <td>{{ $companies->address }}</td>
     </tr>
  </table>

  <br>

  <table>
    <thead>
      <tr>
        <th rowspan="2">NO</th>
        <th rowspan="2">TANGGAL</th>
        <th rowspan="2">KATEGORI</th>
        <th rowspan="2">KETERANGAN</th>
        <th colspan="2">JENIS</th>
      </tr>
      <tr>
        <th>PEMASUKAN</th>
        <th>PENGELUARAN</th>
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
                          @if($cashbook->type == "D")
                          {{ "Rp.".number_format($cashbook->amount).",-" }}
                          @php $sumExpense += $cashbook->amount; @endphp
                          @else
                          {{ "-" }}
                          @endif
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                    <tfoot class="bg-info text-white font-weight-bold">
                      <tr>
                        <td colspan="4" class="text-bold text-right">TOTAL</td>
                        <td class="text-center">{{ "Rp.".number_format($sumIncome).",-" }}</td>
                        <td class="text-center">{{ "Rp.".number_format($sumExpense).",-" }}</td>
      </tr>
    </tfoot>
  </table>
  <tr>
    <td>Report Created</td>
    <td>:</td>
    <td>{{ date('Y-m-d H:i:s') }}</td>
  </tr>
</body>
</html>
