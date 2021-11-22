<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Image</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

</head>

<body>
    <div class="container-fluid">
        <form method="POST" action="{{ route('upload') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="file">Example file input</label>
                <input type="file" name="file" id="file" class="form-control-file">
            </div>
            <button type="submit" class="btn btn-primary">Upload</button>
        </form>
    </div>
    @if (!empty($images))
    <div class="container-fluid">
        <div class="row">
            @foreach ($images as $image)
            <div class="image">
                <img src="{{ $image }}" alt="">
            </div>
            @endforeach
        </div>
    </div>
    @endif
</body>

</html>
