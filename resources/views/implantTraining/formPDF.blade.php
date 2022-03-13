<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <style>
        p {
            text-align: justify;
            font-size: 18px;
        }
    </style>
    <title>OJT Form</title>
</head>

<body>
    <table style="width:100%">
        <tr>
            <td><img src="{{ public_path('images/vtaroundlogo.jpg') }}" alt="Logo" height="50px"></td>
            <td style="width:100%">
                <h3 style="text-align: center; text-decoration: underline;">Vocational Training Authority of Sri Lanka
                </h3>
                <h4 style="text-align: center;">Implant Training Information Form</h4>
            </td>
        </tr>
    </table>
    <hr>

    <table style="width:100%">
        <tr>
            <td>
                <p style="padding: 0px; margin:0px;"><strong>Center :</strong> VTA-Badulla</p>
            </td>
            <td>
                <p style="padding: 0px; margin:0px;"><strong>District :</strong> Badulla</p>
            </td>
        </tr>
        <tr>
            <td>
                <p style="padding: 0px; margin:0px;"><strong>Course :</strong> {{ $course }}</p>
            </td>
            <td>
                <p style="padding: 0px; margin:0px;"><strong>Year/Bacth :</strong> {{ $year }}/{{ $batch_no }}</p>
            </td>
        </tr>
    </table>

    <table style="width:100%; border: 1px solid black; border-collapse: collapse; margin-top: 5px;">
        <tr style="border: 1px solid black;">
            <th style="border: 1px solid black;"></th>
            <th style="text-align: left; border: 1px solid black;">Trainee Name</th>
            <th style="text-align: left; border: 1px solid black;">Trainee Contact No</th>
            <th style="text-align: left; border: 1px solid black;">Start Date</th>
            <th style="text-align: left; border: 1px solid black;">End Date</th>
            <th style="text-align: left; border: 1px solid black;">Training Institute</th>
            <th style="text-align: left; border: 1px solid black;">Institute Contact No</th>
        </tr>
        @foreach ($trainees as $trainee)
        <tr style="border: 1px solid black;">
            <td style="border: 1px solid black;">{{ ++$count }}</td>
            <td style="text-align: left; border: 1px solid black;">{{ $trainee->name_with_initials }}</td>
            <td style="text-align: left; border: 1px solid black;">{{ $trainee->phone_number }}</td>
            <td style="text-align: left; border: 1px solid black;">{{ $trainee->ojt_start_date }}</td>
            <td style="text-align: left; border: 1px solid black;">{{ $trainee->ojt_end_date }}</td>
            <td style="text-align: left; border: 1px solid black;">{{ $trainee->trainingInstitute->name }}</td>
            <td style="text-align: left; border: 1px solid black;">{{ $trainee->trainingInstitute->phone_no }}</td>

        </tr>
        @endforeach
    </table>
</body>

</html>