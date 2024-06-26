<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical Request Slip</title>
</head>
<body>
    <style>
        html {
            margin: 0px;
        }

        body {
            transform: scale(.97);
        }

        * {
            font-size: 13px;
            font-family: 'Times', Verdana, Tahoma, "DejaVu Sans", sans-serif;
        }
        
        /* container divided into 2 col 3 rows */
        .container {
            width: 816px;
            height: 1052px;
            border-collapse: collapse;
        }

        .container th, .container td {
            padding: 0px;
            border-spacing: 0px;
        }

        .container tr:first-child td {
            border-top: none;
        }

        .container tr:last-child td {
            border-bottom: none;
        }

        .container tr td:first-child {
            border-left: none;
        }

        .container tr td:last-child {
            border-right: none;
        }

        .card {
            border: 1px dotted;
            width: 406px;
            height: 348px; 
        }

        /* inner container - form  */
        .item {
            width: 386px;
            height: 328px;
            margin: 10px;
            border: 1px solid;
            /* background-color: gainsboro; */
        }

        .item-table {
            border-collapse: collapse;
        }

        .item-table th, .item-table td {
            padding: 0px;
            border-spacing: 0px;
        }

        .item-table td {
            padding-bottom: 3px;
        }

        .header {
            border-bottom: 1px solid;
        }

        .header td {
            border: 1px solid;
            padding-left: 2px;
            padding-right: 2px;
        }

        .logo {
            width: 40px;
            height: 38px;
        }

        .nb {
            border: none;
        }

        .b {
            border: 1px solid;
        } 

        td .p {
            padding-left: 2px;
            padding-right: 1px;
        }

        td .pt {
            padding-top: 2px;
        }

        .d-none {
            display: none;
        }

        .text-center {
            text-align: center;
        }

        .chck { 
            font-family: DejaVu Sans, sans-serif;
        }

        input[type=checkbox]:before { 
            font-family: DejaVu Sans; 
            font-size: 13px; 
        }

        input[type=checkbox] { 
            display: inline; 
        }

        .underline {
            /* text-decoration: underline;
            word-wrap: normal; */
            border-bottom: 1px solid black;
        }

        span {
            white-space:pre;
        }
    </style>

    @php 
        $col = 2;
        $row = 6;

        $header =  '<tr class="header">
                        <td colspan="3" class="text-center">
                            <img class="logo" src="assets/photos/BSUTNEU_logo.png">
                        </td>
                        <td colspan="8">
                            Reference No. <br>
                            BatStateU-FO-HSD-07
                        </td>
                        <td colspan="6">
                            Effectivity Date:
                            May 18, 2022
                        </td>
                        <td colspan="3">
                            Rev. No. <br>
                            01
                        </td>
                    </tr>';

        $title = '<tr>
                    <td colspan="20" class="text-center pt">
                        <b>BATANGAS STATE UNIVERSITY</b> <br>
                        National Engineering University <br>
                        ARASOF - Nasugbu <br>
                        Nasugbu, Batangas <br>
                        <br>
                        <b>MEDICAL REQUEST SLIP</b>
                    </td>
                </tr>
                ';


        function addSpace($word, $count){
            $diff = strlen($word) - $count;
            $finalWord = $word;

            if($diff < 0){
                for($i= 0; $i<=($diff*-1); $i++){
                    $finalWord = $finalWord . ' ';
                }
            }

            return $finalWord;
        } 
    @endphp
    <table class="container">
        <thead>
            <th class="nb"></th>
        </thead>
        <tbody>
                <tr>
                        <td class="card">
                            <div class="item">
                                <table class="item-table">
                                    <thead>
                                        @for($i=1; $i<=20; $i++)
                                            <th class="nb" style="width: 5%;"></th>
                                        @endfor
                                    </thead>
                                    <tbody>
                                        <!-- 19 row max -->
                                        <!-- 20 columns -->
                                        {!! $header !!}
                                        {!! $title !!}
                                        <tr>
                                            <td colspan="12" class="p">
                                                <div style="display: block; word-wrap: break-word;">
                                                    Name: <span class="underline">{{ addSpace($data->mrs_patient_name, 30) }}</span> 
                                                </div>
                                            </td>
                                            <td colspan="8" class="p">
                                                Date: <span class="underline">{{ addSpace(date_format(date_create($data->mrs_date), "F d, Y"), 17) }}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="12" class="p">
                                                Age: <span class="underline">{{ addSpace($data->mrs_age, 30) }}</span> 
                                            </td>
                                            <td colspan="8" class="p">
                                                Sex: <span class="underline">{{ addSpace(ucwords($data->mrs_sex), 20) }}</span> 
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="20" class="p">
                                                Requested by: <span class="underline">{{ addSpace(ucwords($data->mrs_requested_by), 45) }}</span> 
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="pt"></td>
                                            <td colspan="17" class="pt">
                                                <input type="checkbox" {{ ($data->mrs_chest_xray) ? 'checked' : '' }}> Chest X-ray <br>
                                                <input type="checkbox" {{ ($data->mrs_cbc) ? 'checked' : '' }}> CBC <br>
                                                <input type="checkbox" {{ ($data->mrs_urinalysis) ? 'checked' : '' }}> Urinalysis <br>
                                                <input type="checkbox" {{ ($data->mrs_fecalysis) ? 'checked' : '' }}> Fecalysis <br>
                                                <input type="checkbox" {{ ($data->mrs_drug_test) ? 'checked' : '' }}> Drug Test <br>
                                                <input type="checkbox" {{ ($data->mrs_blood_typing) ? 'checked' : '' }}> Blood Typing <br>
                                                Others: <span class="underline">{{ addSpace(ucwords($data->mrs_others), 75) }}</span> 
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </td>
                </tr>
        </tbody>
        <tfoot>
                <th class="d-none"></th>
        </tfoot>
    </table>
</body>
</html>