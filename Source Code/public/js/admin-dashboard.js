document.addEventListener("DOMContentLoaded", function () {

    /* =====================================================
       VACCINATION CHART
       Data PHP/database se aa raha hai.
       JavaScript sirf chart display kar raha hai.
    ===================================================== */

    const chartCanvas =
        document.getElementById("vaccinationChart");

    const activityFilter =
        document.getElementById("activityFilter");

    let vaccinationChart = null;


    const chartLabels = [
        "Jan",
        "Feb",
        "Mar",
        "Apr",
        "May",
        "Jun",
        "Jul",
        "Aug",
        "Sep",
        "Oct",
        "Nov",
        "Dec"
    ];


    function createVaccinationChart(year) {

        if (
            !chartCanvas ||
            typeof Chart === "undefined"
        ) {
            return;
        }


        if (vaccinationChart) {
            vaccinationChart.destroy();
        }


        const ctx =
            chartCanvas.getContext("2d");


        const gradient =
            ctx.createLinearGradient(
                0,
                0,
                0,
                280
            );


        gradient.addColorStop(
            0,
            "rgba(22, 119, 255, 0.22)"
        );


        gradient.addColorStop(
            1,
            "rgba(22, 119, 255, 0.01)"
        );


        const selectedData =
            vaccinationChartData[year] ||
            new Array(12).fill(0);


        vaccinationChart =
            new Chart(
                ctx,
                {

                    type: "line",

                    data: {

                        labels: chartLabels,

                        datasets: [

                            {

                                label:
                                    "Vaccinations",

                                data:
                                    selectedData,

                                borderColor:
                                    "#1677ff",

                                backgroundColor:
                                    gradient,

                                borderWidth: 3,

                                pointBackgroundColor:
                                    "#ffffff",

                                pointBorderColor:
                                    "#1677ff",

                                pointBorderWidth: 2,

                                pointRadius: 3,

                                pointHoverRadius: 5,

                                fill: true,

                                tension: 0.4

                            }

                        ]

                    },


                    options: {

                        responsive: true,

                        maintainAspectRatio: false,

                        interaction: {

                            intersect: false,

                            mode: "index"

                        },


                        plugins: {

                            legend: {

                                display: false

                            },


                            tooltip: {

                                backgroundColor:
                                    "#17324d",

                                padding: 12,

                                titleFont: {

                                    size: 11

                                },

                                bodyFont: {

                                    size: 11

                                },

                                displayColors: false,


                                callbacks: {

                                    label:
                                        function (context) {

                                            return (
                                                " Vaccinations: " +
                                                context.parsed.y
                                            );

                                        }

                                }

                            }

                        },


                        scales: {

                            x: {

                                grid: {

                                    display: false

                                },

                                border: {

                                    display: false

                                },

                                ticks: {

                                    color:
                                        "#8193a5",

                                    font: {

                                        size: 10

                                    }

                                }

                            },


                            y: {

                                beginAtZero: true,

                                grid: {

                                    color:
                                        "#edf2f6",

                                    drawBorder: false

                                },

                                border: {

                                    display: false

                                },

                                ticks: {

                                    color:
                                        "#8193a5",

                                    font: {

                                        size: 10

                                    },

                                    padding: 8

                                }

                            }

                        }

                    }

                }
            );

    }


    /* =====================================================
       INITIAL CHART
    ===================================================== */

    if (activityFilter) {

        createVaccinationChart(
            activityFilter.value
        );

    }


    /* =====================================================
       YEAR FILTER
    ===================================================== */

    if (activityFilter) {

        activityFilter.addEventListener(
            "change",
            function () {

                createVaccinationChart(
                    this.value
                );

            }
        );

    }


    /* =====================================================
       CARD HOVER
       Visual effect only.
    ===================================================== */

    const statCards =
        document.querySelectorAll(
            ".stat-card"
        );


    statCards.forEach(
        function (card) {

            card.addEventListener(
                "mouseenter",
                function () {

                    this.style.transform =
                        "translateY(-3px)";

                }
            );


            card.addEventListener(
                "mouseleave",
                function () {

                    this.style.transform =
                        "translateY(0)";

                }
            );

        }
    );


    /* =====================================================
       QUICK ACTION FEEDBACK
       Visual effect only.
    ===================================================== */

    const quickActions =
        document.querySelectorAll(
            ".quick-action"
        );


    quickActions.forEach(
        function (action) {

            action.addEventListener(
                "click",
                function () {

                    this.classList.add(
                        "action-clicked"
                    );

                }
            );

        }
    );

});