<!doctype html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=1200, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
</head>

<body class="hold-transition sidebar-mini">
    <style>
        * {
            margin: 0;
            padding: 0;
            line-height: calc(0.25rem + 1em + 0.25rem)
        }

        *,
        ::before,
        ::after {
            box-sizing: border-box
        }

        *:where(:not(fieldset, progress, meter)) {
            border-width: 0;
            border-style: solid;
            background-origin: border-box;
            background-repeat: no-repeat
        }

        html {
            block-size: 100%;
            -webkit-text-size-adjust: none
        }

        @media (prefers-reduced-motion:no-preference) {
            html:focus-within {
                scroll-behavior: smooth
            }
        }

        body {
            -webkit-font-smoothing: antialiased;
            text-rendering: optimizeSpeed;
            min-block-size: 100%
        }

        :where(img, svg, video, canvas, audio, iframe, embed, object) {
            display: block
        }

        :where(img, svg, video) {
            block-size: auto;
            max-inline-size: 100%
        }

        :where(svg) {
            stroke: none;
            fill: currentColor
        }

        :where(svg):where(:not([fill])) {
            stroke: currentColor;
            fill: none;
            stroke-linecap: round;
            stroke-linejoin: round
        }

        :where(svg):where(:not([width])) {
            inline-size: 5rem
        }

        :where(input, button, textarea, select),
        :where(input[type="file"])::-webkit-file-upload-button {
            color: inherit;
            font: inherit;
            font-size: inherit;
            letter-spacing: inherit
        }

        :where(textarea) {
            resize: vertical
        }

        @supports (resize:block) {
            :where(textarea) {
                resize: block
            }
        }

        :where(p, h1, h2, h3, h4, h5, h6) {
            overflow-wrap: break-word
        }

        h1 {
            font-size: 2em
        }

        :where(ul, ol)[role="list"] {
            list-style: none
        }

        a:not([class]) {
            text-decoration-skip-ink: auto
        }

        :where(a[href], area, button, input, label[for], select, summary, textarea, [tabindex]:not([tabindex*="-"])) {
            cursor: pointer;
            touch-action: manipulation
        }

        :where(input[type="file"]) {
            cursor: auto
        }

        :where(input[type="file"])::-webkit-file-upload-button,
        :where(input[type="file"])::file-selector-button {
            cursor: pointer
        }

        @media (prefers-reduced-motion:no-preference) {
            :focus-visible {
                transition: outline-offset 145ms cubic-bezier(.25, 0, .4, 1)
            }

            :where(:not(:active)):focus-visible {
                transition-duration: 0.25s
            }
        }

        :where(:not(:active)):focus-visible {
            outline-offset: 5px
        }

        :where(button, button[type], input[type="button"], input[type="submit"], input[type="reset"]),
        :where(input[type="file"])::-webkit-file-upload-button,
        :where(input[type="file"])::file-selector-button {
            -webkit-tap-highlight-color: transparent;
            -webkit-touch-callout: none;
            user-select: none;
            text-align: center
        }

        :where(button, button[type], input[type="button"], input[type="submit"], input[type="reset"])[disabled] {
            cursor: not-allowed
        }
    </style>
    {!! $send_html !!}
</body>

</html>