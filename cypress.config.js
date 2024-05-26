import { defineConfig } from "cypress";

export default defineConfig({
  e2e: {
    baseUrl: "http://buyer-bridge.test", // Update this to match your development server URL
    setupNodeEvents(on, config) {
      // implement node event listeners here
    },
    specPattern: "cypress/**/**/*.*.{js,jsx,ts,tsx}",
  },

  component: {
    devServer: {
      framework: "vue",
      bundler: "vite",
    },
  },
});
