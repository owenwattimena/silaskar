<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->

    {{-- <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}"> --}}
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>SILASKAR | Rekap Permintaan ATK</title>
    <style>
        * {
            font-family: Arial, Helvetica, sans-serif !important;
            font-size: 12px !important;
        }

        .logo {
            width: 80px;
            margin-right: 10px;
            box-sizing: border-box;
        }

        hr {
            border-top: 3px solid black;
        }

        h1 {
            font-weight: bold;
        }

        #table,
        #table th,
        #table td {
            border: 1px solid black !important;
        }

        .border-hide {
            border-left-color: white !important;
            border-bottom-color: white !important;
        }

        #sign,
        #sign th,
        #sign td {
            border: 1px solid white !important;
        }

    </style>
</head>

<body class="py-5">
    <header class="text-center">
        <table class="mx-auto" style="border:none">
            <tr>
                <td>
                    <img class="logo" src="{{ asset('images/LOGO-PN-AMBON.jpg') }}" alt="LOGO PN Ambon">
                </td>
                <td>
                    <h1 class="text-center">PENGADILAN NEGERI AMBON</h1>
                    <h3 class="text-center">Jl. Sultan Hairun No. 1 Ambon</h3>
                    <h3 class="text-center">Telp : (0911)-352462 Fax (0911)-355477</h3>
                    <h3 class="text-center">AMBON - 97126</h3>
                </td>
            </tr>
        </table>
    </header>
    <hr>

    <h1 class="text-center">REKAP {{ $category }} ATK</h1>
    <h1 class="text-center">{{ $start }} S/D {{ $end }} </h1>

    <table id="table" class="mt-5 table-sm mb-5" width="100%">
        <thead>
            <tr class="text-center">
                <th scope="col">NO</th>
                <th scope="col">NAMA BARANG</th>
                <th scope="col" colspan="2">KUANTITAS</th>
                <th scope="col">HARGA SATUAN(Rp)</th>
                <th scope="col">JUMLAH</th>
            </tr>
        </thead>
        <tbody class="border-hide">
            @php
                setlocale(LC_MONETARY, 'id_ID');
                $no = 0;
                $total = 0;
            @endphp
            @forelse ($reports as $report)
                @php
                    $total += $report->total;
                @endphp
                <tr>
                    <td class="text-center">{{ ++$no }}</td>
                    <td>{{ $report->product->name }}</td>
                    <td class="text-center">{{ $report->stock_quantity }}</td>
                    <td class="text-center">{{ $report->product->unit }}</td>
                    <td class="text-center">Rp{{ number_format($report->total / $report->stock_quantity) }}</td>
                    <td class="text-center">Rp{{ number_format($report->total) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center"> Tidak ada data </td>
                </tr>
            @endforelse

            <tr>
                <td colspan="4">
                </td>
                <td class="text-center">JUMLAH</td>
                <td class="text-center">
                    Rp{{ number_format($total) }}
                </td>
            </tr>
        </tbody>
    </table>
    <table class="table text-center font-weight-bold mt-5" id="sign">
        <tr>
            <td>
                <p class="pb-3">Operator Persediaan</p>
                <p class="mt-5 mb-0">(................................................)</p>
                <p>NIP.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <p>

            </td>
            <td>
                <p class="pb-3">Pejabat Pengadaan</p>
                <p class="mt-5 mb-0">(................................................)</p>
                <p>NIP.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <p>

            </td>
        </tr>
    </table>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
</body>

</html>
