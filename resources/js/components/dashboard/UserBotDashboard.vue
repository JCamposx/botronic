<template>
  <Pie
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
import { Pie } from "vue-chartjs";
import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  ArcElement,
  CategoryScale,
} from "chart.js";

ChartJS.register(Title, Tooltip, Legend, ArcElement, CategoryScale);

export default {
  name: "PieChart",
  components: { Pie },
  props: {
    chartId: {
      type: String,
      default: "pie-chart",
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
      default: 100,
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
            ],
          },
        ],
      },
      chartOptions: {
        responsive: true,
        maintainAspectRatio: true,
        borderWidth: 1,
        plugins: {
          title: {
            display: true,
            text: this.title,
          },
        },
      },
    };
  },
};
</script>
