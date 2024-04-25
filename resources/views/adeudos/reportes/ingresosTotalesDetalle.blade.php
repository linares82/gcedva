<html>

<head>


    <style>
        @media print {
            table {
                border-collapse: collapse;
                width: 100%;
            }

            th,
            td,
            .tr_first {
                text-align: left;
                padding: 8px;
                font: normal 12px Arial, Helvetica, sans-serif;
                border: solid 1px #FE9A2E;
            }

            tr:nth-child(even) {
                background-color: #f2f2f2
            }

            th {
                background-color: #FE9A2E;
                color: white;
                font-weight: bold;
            }
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            text-align: center;
            padding: 8px;
            font: normal 12px Arial, Helvetica, sans-serif;
            border: solid 1px #FE9A2E;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2
        }

        th {
            background-color: #FE9A2E;
            color: white;
        }

        body {
            font: normal 10px Arial, Helvetica, sans-serif;
        }
    </style>

</head>

<body>
    <h1>Total de Ingresos por Plantel</h1>

    <div>
        <canvas id="barChart" style="display: block; box-sizing: border-box; height:auto; width: 40%;"></canvas>
        

    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const ctx = document.getElementById('barChart');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo $formas_pago; ?>,
                datasets: [{
                    label: '<?php echo $plantel ?>',
                    data: <?php echo $data; ?>,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 205, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(201, 203, 207, 0.2)'
                    ],
                    borderColor: [
                        'rgb(255, 99, 132)',
                        'rgb(255, 159, 64)',
                        'rgb(255, 205, 86)',
                        'rgb(75, 192, 192)',
                        'rgb(54, 162, 235)',
                        'rgb(153, 102, 255)',
                        'rgb(201, 203, 207)'
                    ],
                    borderWidth: 1
                }]
            },

            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

    </script>

</body>

</html>