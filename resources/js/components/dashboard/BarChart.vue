<template>
  <Bar
    :chart-options="chartOptions"
    :chart-data="chartData"
    :chart-id="chartId"
    :dataset-id-key="datasetIdKey"
    :plugins="plugins"
    :css-classes="cssClasses"
    :styles="styles"
    :width="width"
    :height="height"
  />
</template>

<script>
import { Bar } from "vue-chartjs";
import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  BarElement,
  CategoryScale,
  LinearScale,
} from "chart.js";

ChartJS.register(
  Title,
  Tooltip,
  Legend,
  BarElement,
  CategoryScale,
  LinearScale
);

export default {
  name: "BarChart",
  components: { Bar },
  props: {
    chartId: {
      type: String,
      default: "bar-chart",
    },
    datasetIdKey: {
      type: String,
      default: "label",
    },
    width: {
      type: Number,
      default: 100,
    },
    height: {
      type: Number,
      default: 650,
    },
    cssClasses: {
      type: String,
      default: "",
    },
    styles: {
      type: Object,
      default: () => {},
    },
    plugins: {
      type: Object,
      default: () => {},
    },
    labels: {
      type: Array,
      default: [""],
    },
    data: {
      type: Array,
      default: [""],
    },
    title: {
      type: String,
      default: "",
    },
  },
  data() {
    return {
      chartData: {
        labels: this.labels,
        datasets: [
          {
            data: this.data,
            backgroundColor: [
              "#EF596F",
              "#89CA78",
              "#E5C07B",
              "#61AFEF",
              "#D55FDE",
              "#D19A66",
              "#2BBAC5",
              "#ABB2BF",
              "#5C6370",
              "#e4e4e4",
            ],
          },
        ],
      },
      chartOptions: {
        responsive: true,
        maintainAspectRatio: false,
        borderWidth: 1,
        plugins: {
          title: {
            display: true,
            text: this.title,
            font: {
              size: 15,
            },
          },
          legend: {
            display: false,
          },
        },
      },
    };
  },
};
</script>
