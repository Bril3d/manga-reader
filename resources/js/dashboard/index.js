import Chart from "chart.js/auto";
const usersChart = document.getElementById("users-chart");
const chaptersChart = document.getElementById("chapters-chart");
const mangaChart = document.getElementById("manga-chart");

new Chart(usersChart, {
  type: "line",
  data: {
    labels: usersLabels,
    datasets: [
      {
        label: language["Users Registered"],
        data: usersData,
        borderWidth: 1,
      },
    ],
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    legend: {
      rtl: true,
    },
    scales: {
      y: {
        beginAtZero: true,
      },
    },
  },
});

new Chart(mangaChart, {
  type: "bar",
  data: {
    labels: mangasLabels,
    datasets: [
      {
        label: language["Mangas Views"],
        data: mangasData,
        borderWidth: 1,
      },
    ],
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    legend: {
      rtl: true,
    },
    scales: {
      y: {
        beginAtZero: true,
      },
    },
  },
});

new Chart(chaptersChart, {
  type: "bar",
  data: {
    labels: chaptersLabels,
    datasets: [
      {
        label: language["Chapters Views"],
        data: chaptersData,
        borderWidth: 1,
      },
    ],
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    legend: {
      rtl: true,
    },
    scales: {
      y: {
        beginAtZero: true,
      },
    },
  },
});

window.scrollTo(0, document.body.scrollHeight);
