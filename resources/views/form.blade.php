<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>

<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-12">
                <form action="{{ isset($id) ? route('update', $id) : route('store') }}" method="post">
                    @csrf
                    @if (isset($id))
                        @method('put')
                    @endif
                    <div class="form-group">
                        <label for="">Name</label>
                        <input type="text" value="{{ isset($id) ? $data->name : '' }}" name="name"
                            class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">Gender</label>
                        <select name="gender" id="gender" class="form-control">
                            <option value="">pilih</option>
                            <option value="laki-laki"
                                {{ isset($id) ? ($data->gender == 'laki-laki' ? 'selected' : '') : '' }}>Laki
                                Laki
                            </option>
                            <option value="perempuan"
                                {{ isset($id) ? ($data->gender == 'perempuan' ? 'selected' : '') : '' }}>Perempuan
                            </option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">ParentID</label>
                        <select name="parentID" id="parentID" class="form-control">
                            <option value="">pilih</option>
                            @foreach ($family as $item)
                                <option value="{{ $item->id }}"
                                    {{ isset($id) ? ($data->parentID == $item->id ? 'selected' : '') : '' }}>
                                    {{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mt-3">
                        <button type="submit" class="btn btn-primary">{{ isset($id) ? 'Update' : 'Create' }}</button>
                        <a href="/" class="btn btn-warning">Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
    </script>
</body>

</html>
