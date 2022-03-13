<!DOCTYPE html
  PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <style>
    p {
      text-align: justify;
    }
  </style>
  <title>OJT Letter</title>
</head>

<body>
  <h3 style="text-align: center;">Vocational Training Authority of Sri Lanka</h3>
  <h3 style="text-align: center;">District vocational training center -Rockhill-Badulla</h3>
  <p>Tel- 055-22224836, 055-22222423</p>
  <hr>

  <div style="margin-left: 40px;margin-right: 40px;">
    <p>{{ $receiver_name }},<br>
      @foreach ($address as $item)
      {{ $item }},
      <br>
      @endforeach
      {{ date("Y-m-d") }}.</p>
    <p><strong>Dear Sir/Madam,</strong></p>
  </div>

  <p style="margin-left: 40px;margin-right: 40px;"><strong>TO WHOM IT MAY CONCERN</strong></p>

  <div style="margin-left: 40px;margin-right: 40px;">
    <p style="text-align: justify;margin-left: 0;"><strong>{{ $trainee_name }}</strong> has followed
      <strong>{{ $course_name }}</strong> full time course which was conducted from
      {{ $start_date }} to {{ $end_date }} at District Vocational Training Center, at BADULLA which is under the
      Vocational Training Authority of Sri Lanka. We wish to attach him to your organization to get hands on
      experience on above mentioned trade area.
    </p>
    <p>We expect following skills during the training period at your place.</p>
    <ol>
      <li>Task Performance, task management controlling, unexpected situation, trouble shooting</li>
      <li>Better exposure to the working environment and job category.</li>
      <li>Shifting skills (adaptation for the modern technology and machines).</li>
      <li>Upgrading soft skills (public relationship).</li>
      <li>Upgrading other skills of trainees.</li>
    </ol>
    <p>The minimum on the job training requirements for the final examination is six months in your organization.
      It is appreciated if you can pay reasonable amount stipend for this trainee as he will directly involve the
      process of services in your organization.
    </p>
    <p>Please be kind enough to grant leave on the first Wednesday of every month to report our institute with
      his attendance of the previous month. This is essential for us discuss about their training in your
      organization
    </p>
    <p>The course content is annexed here with for your kind perusal please.</p>
    <p>Your co-operation in this regard is highly appreciated.</p>
  </div>

  <div style="margin-left: 40px;margin-right: 40px;">
    <p>Thank You.</p>
  </div>

  <div style="margin-left: 40px;margin-right: 40px;">
    <p></p>
    <br>
    <p>
      Center Manager,<br>
      District Vocational Training Center,<br>
      Rockhill, Badulla.
    </p>
  </div>
</body>
</body>

</html>