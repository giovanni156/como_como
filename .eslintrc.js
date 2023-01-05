module.exports = {
    env: {
        node: true,
    },
    extends: ["eslint:recommended", "plugin:vue/vue3-recommended", "prettier"],
    rules: {
        "sort-imports":
            [
                "error",
                {
                    "ignoreCase": true,
                    "ignoreDeclarationSort": true
                }
            ],
        "import/order":
            [
                1,
                {
                    "groups":
                        [
                            "external",
                            "builtin",
                            "internal",
                            "sibling",
                            "parent",
                            "index"
                        ],
                    "pathGroups": [
                        {
                            "pattern": "components",
                            "group": "internal"
                        },
                        {
                            "pattern": "common",
                            "group": "internal"
                        },
                        {
                            "pattern": "routes/ **",
                            "group": "internal"
                        },
                        {
                            "pattern": "assets/**",
                            "group": "internal",
                            "position": "after"
                        }
                    ],
                    "pathGroupsExcludedImportTypes":
                        [
                            "internal"
                        ],
                    "alphabetize": {
                        "order": "asc",
                        "caseInsensitive": true
                    }
                }
            ]
    },
    parserOptions: {
        ecmaVersion: 12,
        sourceType: "module",
        parser: "@typescript-eslint/parser",
    },
    plugins: ["vue", "@typescript-eslint", "import"],
    overrides: [
        {
            files: [".ts", ".mts", ".cts", ".tsx", '.vue', ".js", "*.json"],
            rules: {
                "no-undef": "off",
            },
        },
    ],
}
