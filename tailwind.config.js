const defaultTheme = require("tailwindcss/defaultTheme");

module.exports = {
    purge: {
        enabled: true,
        content: ["./resources/**/*.{vue,js,blade.php}"],
    },

    theme: {
        extend: {
            fontFamily: {
                sans: ["Nunito", ...defaultTheme.fontFamily.sans],
                body: ["Sora", "sans-serif"],
            },
            colors: {
                dblue: "#2C2E43",
                brown: "#595260",
                white: "#ffffff",
                cgray: "#B2B1B9",
            },
            backgroundColor: (theme) => ({
                ...theme("colors"),
                sky: "#F4F5F9",
                dblue: "#2C2E43",
                brown: "#595260",
                cgray: "#B2B1B9",
            }),
            inset: {
                xfull: "130%",
            },
        },
    },

    variants: {
        extend: {
            opacity: ["disabled"],
            cursor: ["disabled"],
            backgroundOpacity: ["disabled"],
        },
    },

    plugins: [require("@tailwindcss/forms")],
};
