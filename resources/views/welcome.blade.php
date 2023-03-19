<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.2.3/axios.min.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {
            packages: ["orgchart"]
        });
        google.charts.setOnLoadCallback(drawChart);

        async function drawChart() {
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Name');
            data.addColumn('string', 'Manager');
            data.addColumn('string', 'ToolTip');

            // For each orgchart box, provide the name, manager, and tooltip to show.
            let grandPa = [];
            let childs = [];
            let grandchild = [];
            await axios.get('http://localhost:8000/api/family')
                .then(function(response) {
                    // handle success
                    let res = response?.data
                    console.log(res)
                    res.map((el) => {
                        grandPa = [
                            ...grandPa,
                            [{
                                'v': el.name,
                            }, '', el.gender]
                        ]
                        el.child.map((el2) => {
                            childs = [
                                ...childs,
                                [{
                                    'v': el2.name,
                                }, el.name, el2.gender]
                            ]
                            el2.grandChild.map((el3) => {
                                grandchild = [
                                    ...grandchild,
                                    [{
                                        'v': el3.name,
                                    }, el2.name, el3.gender]
                                ]
                            })
                        })
                    })
                })
            childs.map((el) => {
                grandPa.push(el)
            })
            grandchild.map((el) => {
                grandPa.push(el)
            })
            console.log(...grandPa)
            console.log(...grandchild)
            data.addRows(

                [
                    ...grandPa
                ]
            );

            // Create the chart.
            var chart = new google.visualization.OrgChart(document.getElementById('chart_div'));
            // Draw the chart, setting the allowHtml option to true for the tooltips.
            chart.draw(data, {
                'allowHtml': true
            });
        }
    </script>

</head>

<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-12">
                <p>For Api Documentation <a href="/api/documentation" target="blank">click here</a></p>
                <a href="/create" class="btn btn-primary">Create</a>
                <table class="table">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>Nama</th>
                            <th>Gender</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->gender }}</td>
                                <td>
                                    <a href="{{ route('edit', $item->id) }}" class="text-primary">edit</a>
                                    <a href="#"
                                        onclick="event.preventDefault(); document.getElementById('form-delete{{ $loop->iteration }}').submit();"
                                        class="text-danger">delete</a>
                                    <form action="{{ route('destroy', $item->id) }}" method="post"
                                        id="form-delete{{ $loop->iteration }}">
                                        @csrf
                                        @method('delete')
                                    </form>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-12">
                <h1 class="text-center mb-3">Visualisasi Tree</h1>
                <div id="chart_div"></div>
            </div>
        </div>
        <br>
        <br>
        <br>
        <br>
        <br>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
    </script>
</body>

</html>
