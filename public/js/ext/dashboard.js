/* globals Chart:false, feather:false */

(function () {
  'use strict'

  feather.replace()

  // Graphs
  var ctx01 = document.getElementById('myChart01')
    var ctx02 = document.getElementById('myChart02')

    window.chartColors = {
        red: 'rgb(255, 99, 132)',
        orange: 'rgb(255, 159, 64)',
        yellow: 'rgb(255, 205, 86)',
        green: 'rgb(75, 192, 192)',
        blue: 'rgb(54, 162, 235)',
        purple: 'rgb(153, 102, 255)',
        grey: 'rgb(201, 203, 207)'
    };
  // eslint-disable-next-line no-unused-vars
  var myChart = new Chart(ctx01, {
      type: 'pie',
      data: {
          datasets: [{
              data: [
                  42,
                  58
              ],
              backgroundColor: [
                  window.chartColors.blue,
                  window.chartColors.red,
              ],
              label: 'Dataset 1'
          }],
          labels: [
              'Meta',
              'Pendiente'
          ]
      },
      options: {
          responsive: true
      }
  })
    var myChart = new Chart(ctx02, {
        type: 'pie',
        data: {
            datasets: [{
                data: [
                    42,
                    58
                ],
                backgroundColor: [
                    window.chartColors.blue,
                    window.chartColors.red,
                ],
                label: 'Dataset 1'
            }],
            labels: [
                'Meta',
                'Pendiente'
            ]
        },
        options: {
            responsive: true
        }
    })
}())
