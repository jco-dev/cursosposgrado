<style>
    /*
 * The MIT License
 * Copyright (c) 2012 Matias Meno <m@tias.me>
 */
    @-webkit-keyframes passing-through {
        0% {
            opacity: 0;
            -webkit-transform: translateY(40px);
            -moz-transform: translateY(40px);
            -ms-transform: translateY(40px);
            -o-transform: translateY(40px);
            transform: translateY(40px);
        }

        30%,
        70% {
            opacity: 1;
            -webkit-transform: translateY(0px);
            -moz-transform: translateY(0px);
            -ms-transform: translateY(0px);
            -o-transform: translateY(0px);
            transform: translateY(0px);
        }

        100% {
            opacity: 0;
            -webkit-transform: translateY(-40px);
            -moz-transform: translateY(-40px);
            -ms-transform: translateY(-40px);
            -o-transform: translateY(-40px);
            transform: translateY(-40px);
        }
    }

    @-moz-keyframes passing-through {
        0% {
            opacity: 0;
            -webkit-transform: translateY(40px);
            -moz-transform: translateY(40px);
            -ms-transform: translateY(40px);
            -o-transform: translateY(40px);
            transform: translateY(40px);
        }

        30%,
        70% {
            opacity: 1;
            -webkit-transform: translateY(0px);
            -moz-transform: translateY(0px);
            -ms-transform: translateY(0px);
            -o-transform: translateY(0px);
            transform: translateY(0px);
        }

        100% {
            opacity: 0;
            -webkit-transform: translateY(-40px);
            -moz-transform: translateY(-40px);
            -ms-transform: translateY(-40px);
            -o-transform: translateY(-40px);
            transform: translateY(-40px);
        }
    }

    @keyframes passing-through {
        0% {
            opacity: 0;
            -webkit-transform: translateY(40px);
            -moz-transform: translateY(40px);
            -ms-transform: translateY(40px);
            -o-transform: translateY(40px);
            transform: translateY(40px);
        }

        30%,
        70% {
            opacity: 1;
            -webkit-transform: translateY(0px);
            -moz-transform: translateY(0px);
            -ms-transform: translateY(0px);
            -o-transform: translateY(0px);
            transform: translateY(0px);
        }

        100% {
            opacity: 0;
            -webkit-transform: translateY(-40px);
            -moz-transform: translateY(-40px);
            -ms-transform: translateY(-40px);
            -o-transform: translateY(-40px);
            transform: translateY(-40px);
        }
    }

    @-webkit-keyframes slide-in {
        0% {
            opacity: 0;
            -webkit-transform: translateY(40px);
            -moz-transform: translateY(40px);
            -ms-transform: translateY(40px);
            -o-transform: translateY(40px);
            transform: translateY(40px);
        }

        30% {
            opacity: 1;
            -webkit-transform: translateY(0px);
            -moz-transform: translateY(0px);
            -ms-transform: translateY(0px);
            -o-transform: translateY(0px);
            transform: translateY(0px);
        }
    }

    @-moz-keyframes slide-in {
        0% {
            opacity: 0;
            -webkit-transform: translateY(40px);
            -moz-transform: translateY(40px);
            -ms-transform: translateY(40px);
            -o-transform: translateY(40px);
            transform: translateY(40px);
        }

        30% {
            opacity: 1;
            -webkit-transform: translateY(0px);
            -moz-transform: translateY(0px);
            -ms-transform: translateY(0px);
            -o-transform: translateY(0px);
            transform: translateY(0px);
        }
    }

    @keyframes slide-in {
        0% {
            opacity: 0;
            -webkit-transform: translateY(40px);
            -moz-transform: translateY(40px);
            -ms-transform: translateY(40px);
            -o-transform: translateY(40px);
            transform: translateY(40px);
        }

        30% {
            opacity: 1;
            -webkit-transform: translateY(0px);
            -moz-transform: translateY(0px);
            -ms-transform: translateY(0px);
            -o-transform: translateY(0px);
            transform: translateY(0px);
        }
    }

    @-webkit-keyframes pulse {
        0% {
            -webkit-transform: scale(1);
            -moz-transform: scale(1);
            -ms-transform: scale(1);
            -o-transform: scale(1);
            transform: scale(1);
        }

        10% {
            -webkit-transform: scale(1.1);
            -moz-transform: scale(1.1);
            -ms-transform: scale(1.1);
            -o-transform: scale(1.1);
            transform: scale(1.1);
        }

        20% {
            -webkit-transform: scale(1);
            -moz-transform: scale(1);
            -ms-transform: scale(1);
            -o-transform: scale(1);
            transform: scale(1);
        }
    }

    @-moz-keyframes pulse {
        0% {
            -webkit-transform: scale(1);
            -moz-transform: scale(1);
            -ms-transform: scale(1);
            -o-transform: scale(1);
            transform: scale(1);
        }

        10% {
            -webkit-transform: scale(1.1);
            -moz-transform: scale(1.1);
            -ms-transform: scale(1.1);
            -o-transform: scale(1.1);
            transform: scale(1.1);
        }

        20% {
            -webkit-transform: scale(1);
            -moz-transform: scale(1);
            -ms-transform: scale(1);
            -o-transform: scale(1);
            transform: scale(1);
        }
    }

    @keyframes pulse {
        0% {
            -webkit-transform: scale(1);
            -moz-transform: scale(1);
            -ms-transform: scale(1);
            -o-transform: scale(1);
            transform: scale(1);
        }

        10% {
            -webkit-transform: scale(1.1);
            -moz-transform: scale(1.1);
            -ms-transform: scale(1.1);
            -o-transform: scale(1.1);
            transform: scale(1.1);
        }

        20% {
            -webkit-transform: scale(1);
            -moz-transform: scale(1);
            -ms-transform: scale(1);
            -o-transform: scale(1);
            transform: scale(1);
        }
    }

    .multimediaFisica,
    .multimediaFisica * {
        box-sizing: border-box;
    }

    .multimediaFisica {
        min-height: 150px;
        border: 2px solid rgba(0, 0, 0, 0.3);
        background: white;
        padding: 20px 20px;
    }

    .multimediaFisica.dz-clickable {
        cursor: pointer;
    }

    .multimediaFisica.dz-clickable * {
        cursor: default;
    }

    .multimediaFisica.dz-clickable .dz-message,
    .multimediaFisica.dz-clickable .dz-message * {
        cursor: pointer;
    }

    .multimediaFisica.dz-started .dz-message {
        display: none;
    }

    .multimediaFisica.dz-drag-hover {
        border-style: solid;
    }

    .multimediaFisica.dz-drag-hover .dz-message {
        opacity: 0.5;
    }

    .multimediaFisica .dz-message {
        text-align: center;
        margin: 2em 0;
    }

    .multimediaFisica .dz-preview {
        position: relative;
        display: inline-block;
        vertical-align: top;
        margin: 16px;
        min-height: 100px;
    }

    .multimediaFisica .dz-preview:hover {
        z-index: 1000;
    }

    .multimediaFisica .dz-preview:hover .dz-details {
        opacity: 1;
    }

    .multimediaFisica .dz-preview.dz-file-preview .dz-image {
        border-radius: 20px;
        background: #999;
        background: linear-gradient(to bottom, #eee, #ddd);
    }

    .multimediaFisica .dz-preview.dz-file-preview .dz-details {
        opacity: 1;
    }

    .multimediaFisica .dz-preview.dz-image-preview {
        background: white;
    }

    .multimediaFisica .dz-preview.dz-image-preview .dz-details {
        -webkit-transition: opacity 0.2s linear;
        -moz-transition: opacity 0.2s linear;
        -ms-transition: opacity 0.2s linear;
        -o-transition: opacity 0.2s linear;
        transition: opacity 0.2s linear;
    }

    .multimediaFisica .dz-preview .dz-remove {
        font-size: 14px;
        text-align: center;
        display: block;
        cursor: pointer;
        border: none;
    }

    .multimediaFisica .dz-preview .dz-remove:hover {
        text-decoration: underline;
    }

    .multimediaFisica .dz-preview:hover .dz-details {
        opacity: 1;
    }

    .multimediaFisica .dz-preview .dz-details {
        z-index: 20;
        position: absolute;
        top: 0;
        left: 0;
        opacity: 0;
        font-size: 13px;
        min-width: 100%;
        max-width: 100%;
        padding: 2em 1em;
        text-align: center;
        color: rgba(0, 0, 0, 0.9);
        line-height: 150%;
    }

    .multimediaFisica .dz-preview .dz-details .dz-size {
        margin-bottom: 1em;
        font-size: 16px;
    }

    .multimediaFisica .dz-preview .dz-details .dz-filename {
        white-space: nowrap;
    }

    .multimediaFisica .dz-preview .dz-details .dz-filename:hover span {
        border: 1px solid rgba(200, 200, 200, 0.8);
        background-color: rgba(255, 255, 255, 0.8);
    }

    .multimediaFisica .dz-preview .dz-details .dz-filename:not(:hover) {
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .multimediaFisica .dz-preview .dz-details .dz-filename:not(:hover) span {
        border: 1px solid transparent;
    }

    .multimediaFisica .dz-preview .dz-details .dz-filename span,
    .multimediaFisica .dz-preview .dz-details .dz-size span {
        background-color: rgba(255, 255, 255, 0.4);
        padding: 0 0.4em;
        border-radius: 3px;
    }

    .multimediaFisica .dz-preview:hover .dz-image img {
        -webkit-transform: scale(1.05, 1.05);
        -moz-transform: scale(1.05, 1.05);
        -ms-transform: scale(1.05, 1.05);
        -o-transform: scale(1.05, 1.05);
        transform: scale(1.05, 1.05);
        -webkit-filter: blur(8px);
        filter: blur(8px);
    }

    .multimediaFisica .dz-preview .dz-image {
        border-radius: 20px;
        overflow: hidden;
        width: 120px;
        height: 120px;
        position: relative;
        display: block;
        z-index: 10;
    }

    .multimediaFisica .dz-preview .dz-image img {
        display: block;
    }

    .multimediaFisica .dz-preview.dz-success .dz-success-mark {
        -webkit-animation: passing-through 3s cubic-bezier(0.77, 0, 0.175, 1);
        -moz-animation: passing-through 3s cubic-bezier(0.77, 0, 0.175, 1);
        -ms-animation: passing-through 3s cubic-bezier(0.77, 0, 0.175, 1);
        -o-animation: passing-through 3s cubic-bezier(0.77, 0, 0.175, 1);
        animation: passing-through 3s cubic-bezier(0.77, 0, 0.175, 1);
    }

    .multimediaFisica .dz-preview.dz-error .dz-error-mark {
        opacity: 1;
        -webkit-animation: slide-in 3s cubic-bezier(0.77, 0, 0.175, 1);
        -moz-animation: slide-in 3s cubic-bezier(0.77, 0, 0.175, 1);
        -ms-animation: slide-in 3s cubic-bezier(0.77, 0, 0.175, 1);
        -o-animation: slide-in 3s cubic-bezier(0.77, 0, 0.175, 1);
        animation: slide-in 3s cubic-bezier(0.77, 0, 0.175, 1);
    }

    .multimediaFisica .dz-preview .dz-success-mark,
    .multimediaFisica .dz-preview .dz-error-mark {
        pointer-events: none;
        opacity: 0;
        z-index: 500;
        position: absolute;
        display: block;
        top: 50%;
        left: 50%;
        margin-left: -27px;
        margin-top: -27px;
    }

    .multimediaFisica .dz-preview .dz-success-mark svg,
    .multimediaFisica .dz-preview .dz-error-mark svg {
        display: block;
        width: 54px;
        height: 54px;
    }

    .multimediaFisica .dz-preview.dz-processing .dz-progress {
        opacity: 1;
        -webkit-transition: all 0.2s linear;
        -moz-transition: all 0.2s linear;
        -ms-transition: all 0.2s linear;
        -o-transition: all 0.2s linear;
        transition: all 0.2s linear;
    }

    .multimediaFisica .dz-preview.dz-complete .dz-progress {
        opacity: 0;
        -webkit-transition: opacity 0.4s ease-in;
        -moz-transition: opacity 0.4s ease-in;
        -ms-transition: opacity 0.4s ease-in;
        -o-transition: opacity 0.4s ease-in;
        transition: opacity 0.4s ease-in;
    }

    .multimediaFisica .dz-preview:not(.dz-processing) .dz-progress {
        -webkit-animation: pulse 6s ease infinite;
        -moz-animation: pulse 6s ease infinite;
        -ms-animation: pulse 6s ease infinite;
        -o-animation: pulse 6s ease infinite;
        animation: pulse 6s ease infinite;
    }

    .multimediaFisica .dz-preview .dz-progress {
        opacity: 1;
        z-index: 1000;
        pointer-events: none;
        position: absolute;
        height: 16px;
        left: 50%;
        top: 50%;
        margin-top: -8px;
        width: 80px;
        margin-left: -40px;
        background: rgba(255, 255, 255, 0.9);
        -webkit-transform: scale(1);
        border-radius: 8px;
        overflow: hidden;
    }

    .multimediaFisica .dz-preview .dz-progress .dz-upload {
        background: #333;
        background: linear-gradient(to bottom, #666, #444);
        position: absolute;
        top: 0;
        left: 0;
        bottom: 0;
        width: 0;
        -webkit-transition: width 300ms ease-in-out;
        -moz-transition: width 300ms ease-in-out;
        -ms-transition: width 300ms ease-in-out;
        -o-transition: width 300ms ease-in-out;
        transition: width 300ms ease-in-out;
    }

    .multimediaFisica .dz-preview.dz-error .dz-error-message {
        display: block;
    }

    .multimediaFisica .dz-preview.dz-error:hover .dz-error-message {
        opacity: 1;
        pointer-events: auto;
    }

    .multimediaFisica .dz-preview .dz-error-message {
        pointer-events: none;
        z-index: 1000;
        position: absolute;
        display: block;
        display: none;
        opacity: 0;
        -webkit-transition: opacity 0.3s ease;
        -moz-transition: opacity 0.3s ease;
        -ms-transition: opacity 0.3s ease;
        -o-transition: opacity 0.3s ease;
        transition: opacity 0.3s ease;
        border-radius: 8px;
        font-size: 13px;
        top: 130px;
        left: -10px;
        width: 140px;
        background: #be2626;
        background: linear-gradient(to bottom, #be2626, #a92222);
        padding: 0.5em 1.2em;
        color: white;
    }

    .multimediaFisica .dz-preview .dz-error-message:after {
        content: '';
        position: absolute;
        top: -6px;
        left: 64px;
        width: 0;
        height: 0;
        border-left: 6px solid transparent;
        border-right: 6px solid transparent;
        border-bottom: 6px solid #be2626;
    }

    .multimediaFisica1,
    .multimediaFisica1 * {
        box-sizing: border-box;
    }

    .multimediaFisica1 {
        min-height: 150px;
        border: 2px solid rgba(0, 0, 0, 0.3);
        background: white;
        padding: 20px 20px;
    }

    .multimediaFisica1.dz-clickable {
        cursor: pointer;
    }

    .multimediaFisica1.dz-clickable * {
        cursor: default;
    }

    .multimediaFisica1.dz-clickable .dz-message,
    .multimediaFisica1.dz-clickable .dz-message * {
        cursor: pointer;
    }

    .multimediaFisica1.dz-started .dz-message {
        display: none;
    }

    .multimediaFisica1.dz-drag-hover {
        border-style: solid;
    }

    .multimediaFisica1.dz-drag-hover .dz-message {
        opacity: 0.5;
    }

    .multimediaFisica1 .dz-message {
        text-align: center;
        margin: 2em 0;
    }

    .multimediaFisica1 .dz-preview {
        position: relative;
        display: inline-block;
        vertical-align: top;
        margin: 16px;
        min-height: 100px;
    }

    .multimediaFisica1 .dz-preview:hover {
        z-index: 1000;
    }

    .multimediaFisica1 .dz-preview:hover .dz-details {
        opacity: 1;
    }

    .multimediaFisica1 .dz-preview.dz-file-preview .dz-image {
        border-radius: 20px;
        background: #999;
        background: linear-gradient(to bottom, #eee, #ddd);
    }

    .multimediaFisica1 .dz-preview.dz-file-preview .dz-details {
        opacity: 1;
    }

    .multimediaFisica1 .dz-preview.dz-image-preview {
        background: white;
    }

    .multimediaFisica1 .dz-preview.dz-image-preview .dz-details {
        -webkit-transition: opacity 0.2s linear;
        -moz-transition: opacity 0.2s linear;
        -ms-transition: opacity 0.2s linear;
        -o-transition: opacity 0.2s linear;
        transition: opacity 0.2s linear;
    }

    .multimediaFisica1 .dz-preview .dz-remove {
        font-size: 14px;
        text-align: center;
        display: block;
        cursor: pointer;
        border: none;
    }

    .multimediaFisica1 .dz-preview .dz-remove:hover {
        text-decoration: underline;
    }

    .multimediaFisica1 .dz-preview:hover .dz-details {
        opacity: 1;
    }

    .multimediaFisica1 .dz-preview .dz-details {
        z-index: 20;
        position: absolute;
        top: 0;
        left: 0;
        opacity: 0;
        font-size: 13px;
        min-width: 100%;
        max-width: 100%;
        padding: 2em 1em;
        text-align: center;
        color: rgba(0, 0, 0, 0.9);
        line-height: 150%;
    }

    .multimediaFisica1 .dz-preview .dz-details .dz-size {
        margin-bottom: 1em;
        font-size: 16px;
    }

    .multimediaFisica1 .dz-preview .dz-details .dz-filename {
        white-space: nowrap;
    }

    .multimediaFisica1 .dz-preview .dz-details .dz-filename:hover span {
        border: 1px solid rgba(200, 200, 200, 0.8);
        background-color: rgba(255, 255, 255, 0.8);
    }

    .multimediaFisica1 .dz-preview .dz-details .dz-filename:not(:hover) {
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .multimediaFisica1 .dz-preview .dz-details .dz-filename:not(:hover) span {
        border: 1px solid transparent;
    }

    .multimediaFisica1 .dz-preview .dz-details .dz-filename span,
    .multimediaFisica1 .dz-preview .dz-details .dz-size span {
        background-color: rgba(255, 255, 255, 0.4);
        padding: 0 0.4em;
        border-radius: 3px;
    }

    .multimediaFisica1 .dz-preview:hover .dz-image img {
        -webkit-transform: scale(1.05, 1.05);
        -moz-transform: scale(1.05, 1.05);
        -ms-transform: scale(1.05, 1.05);
        -o-transform: scale(1.05, 1.05);
        transform: scale(1.05, 1.05);
        -webkit-filter: blur(8px);
        filter: blur(8px);
    }

    .multimediaFisica1 .dz-preview .dz-image {
        border-radius: 20px;
        overflow: hidden;
        width: 120px;
        height: 120px;
        position: relative;
        display: block;
        z-index: 10;
    }

    .multimediaFisica1 .dz-preview .dz-image img {
        display: block;
    }

    .multimediaFisica1 .dz-preview.dz-success .dz-success-mark {
        -webkit-animation: passing-through 3s cubic-bezier(0.77, 0, 0.175, 1);
        -moz-animation: passing-through 3s cubic-bezier(0.77, 0, 0.175, 1);
        -ms-animation: passing-through 3s cubic-bezier(0.77, 0, 0.175, 1);
        -o-animation: passing-through 3s cubic-bezier(0.77, 0, 0.175, 1);
        animation: passing-through 3s cubic-bezier(0.77, 0, 0.175, 1);
    }

    .multimediaFisica1 .dz-preview.dz-error .dz-error-mark {
        opacity: 1;
        -webkit-animation: slide-in 3s cubic-bezier(0.77, 0, 0.175, 1);
        -moz-animation: slide-in 3s cubic-bezier(0.77, 0, 0.175, 1);
        -ms-animation: slide-in 3s cubic-bezier(0.77, 0, 0.175, 1);
        -o-animation: slide-in 3s cubic-bezier(0.77, 0, 0.175, 1);
        animation: slide-in 3s cubic-bezier(0.77, 0, 0.175, 1);
    }

    .multimediaFisica1 .dz-preview .dz-success-mark,
    .multimediaFisica1 .dz-preview .dz-error-mark {
        pointer-events: none;
        opacity: 0;
        z-index: 500;
        position: absolute;
        display: block;
        top: 50%;
        left: 50%;
        margin-left: -27px;
        margin-top: -27px;
    }

    .multimediaFisica1 .dz-preview .dz-success-mark svg,
    .multimediaFisica1 .dz-preview .dz-error-mark svg {
        display: block;
        width: 54px;
        height: 54px;
    }

    .multimediaFisica1 .dz-preview.dz-processing .dz-progress {
        opacity: 1;
        -webkit-transition: all 0.2s linear;
        -moz-transition: all 0.2s linear;
        -ms-transition: all 0.2s linear;
        -o-transition: all 0.2s linear;
        transition: all 0.2s linear;
    }

    .multimediaFisica1 .dz-preview.dz-complete .dz-progress {
        opacity: 0;
        -webkit-transition: opacity 0.4s ease-in;
        -moz-transition: opacity 0.4s ease-in;
        -ms-transition: opacity 0.4s ease-in;
        -o-transition: opacity 0.4s ease-in;
        transition: opacity 0.4s ease-in;
    }

    .multimediaFisica1 .dz-preview:not(.dz-processing) .dz-progress {
        -webkit-animation: pulse 6s ease infinite;
        -moz-animation: pulse 6s ease infinite;
        -ms-animation: pulse 6s ease infinite;
        -o-animation: pulse 6s ease infinite;
        animation: pulse 6s ease infinite;
    }

    .multimediaFisica1 .dz-preview .dz-progress {
        opacity: 1;
        z-index: 1000;
        pointer-events: none;
        position: absolute;
        height: 16px;
        left: 50%;
        top: 50%;
        margin-top: -8px;
        width: 80px;
        margin-left: -40px;
        background: rgba(255, 255, 255, 0.9);
        -webkit-transform: scale(1);
        border-radius: 8px;
        overflow: hidden;
    }

    .multimediaFisica1 .dz-preview .dz-progress .dz-upload {
        background: #333;
        background: linear-gradient(to bottom, #666, #444);
        position: absolute;
        top: 0;
        left: 0;
        bottom: 0;
        width: 0;
        -webkit-transition: width 300ms ease-in-out;
        -moz-transition: width 300ms ease-in-out;
        -ms-transition: width 300ms ease-in-out;
        -o-transition: width 300ms ease-in-out;
        transition: width 300ms ease-in-out;
    }

    .multimediaFisica1 .dz-preview.dz-error .dz-error-message {
        display: block;
    }

    .multimediaFisica1 .dz-preview.dz-error:hover .dz-error-message {
        opacity: 1;
        pointer-events: auto;
    }

    .multimediaFisica1 .dz-preview .dz-error-message {
        pointer-events: none;
        z-index: 1000;
        position: absolute;
        display: block;
        display: none;
        opacity: 0;
        -webkit-transition: opacity 0.3s ease;
        -moz-transition: opacity 0.3s ease;
        -ms-transition: opacity 0.3s ease;
        -o-transition: opacity 0.3s ease;
        transition: opacity 0.3s ease;
        border-radius: 8px;
        font-size: 13px;
        top: 130px;
        left: -10px;
        width: 140px;
        background: #be2626;
        background: linear-gradient(to bottom, #be2626, #a92222);
        padding: 0.5em 1.2em;
        color: white;
    }

    .multimediaFisica1 .dz-preview .dz-error-message:after {
        content: '';
        position: absolute;
        top: -6px;
        left: 64px;
        width: 0;
        height: 0;
        border-left: 6px solid transparent;
        border-right: 6px solid transparent;
        border-bottom: 6px solid #be2626;
    }

    /** multimedia 3 */
    .multimediaFisica3,
    .multimediaFisica3 * {
        box-sizing: border-box;
    }

    .multimediaFisica3 {
        min-height: 150px;
        border: 2px solid rgba(0, 0, 0, 0.3);
        background: white;
        padding: 20px 20px;
    }

    .multimediaFisica3.dz-clickable {
        cursor: pointer;
    }

    .multimediaFisica3.dz-clickable * {
        cursor: default;
    }

    .multimediaFisica3.dz-clickable .dz-message,
    .multimediaFisica3.dz-clickable .dz-message * {
        cursor: pointer;
    }

    .multimediaFisica3.dz-started .dz-message {
        display: none;
    }

    .multimediaFisica3.dz-drag-hover {
        border-style: solid;
    }

    .multimediaFisica3.dz-drag-hover .dz-message {
        opacity: 0.5;
    }

    .multimediaFisica3 .dz-message {
        text-align: center;
        margin: 2em 0;
    }

    .multimediaFisica3 .dz-preview {
        position: relative;
        display: inline-block;
        vertical-align: top;
        margin: 16px;
        min-height: 100px;
    }

    .multimediaFisica3 .dz-preview:hover {
        z-index: 1000;
    }

    .multimediaFisica3 .dz-preview:hover .dz-details {
        opacity: 1;
    }

    .multimediaFisica3 .dz-preview.dz-file-preview .dz-image {
        border-radius: 20px;
        background: #999;
        background: linear-gradient(to bottom, #eee, #ddd);
    }

    .multimediaFisica3 .dz-preview.dz-file-preview .dz-details {
        opacity: 1;
    }

    .multimediaFisica3 .dz-preview.dz-image-preview {
        background: white;
    }

    .multimediaFisica3 .dz-preview.dz-image-preview .dz-details {
        -webkit-transition: opacity 0.2s linear;
        -moz-transition: opacity 0.2s linear;
        -ms-transition: opacity 0.2s linear;
        -o-transition: opacity 0.2s linear;
        transition: opacity 0.2s linear;
    }

    .multimediaFisica3 .dz-preview .dz-remove {
        font-size: 14px;
        text-align: center;
        display: block;
        cursor: pointer;
        border: none;
    }

    .multimediaFisica3 .dz-preview .dz-remove:hover {
        text-decoration: underline;
    }

    .multimediaFisica3 .dz-preview:hover .dz-details {
        opacity: 1;
    }

    .multimediaFisica3 .dz-preview .dz-details {
        z-index: 20;
        position: absolute;
        top: 0;
        left: 0;
        opacity: 0;
        font-size: 13px;
        min-width: 100%;
        max-width: 100%;
        padding: 2em 1em;
        text-align: center;
        color: rgba(0, 0, 0, 0.9);
        line-height: 150%;
    }

    .multimediaFisica3 .dz-preview .dz-details .dz-size {
        margin-bottom: 1em;
        font-size: 16px;
    }

    .multimediaFisica3 .dz-preview .dz-details .dz-filename {
        white-space: nowrap;
    }

    .multimediaFisica3 .dz-preview .dz-details .dz-filename:hover span {
        border: 1px solid rgba(200, 200, 200, 0.8);
        background-color: rgba(255, 255, 255, 0.8);
    }

    .multimediaFisica3 .dz-preview .dz-details .dz-filename:not(:hover) {
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .multimediaFisica3 .dz-preview .dz-details .dz-filename:not(:hover) span {
        border: 1px solid transparent;
    }

    .multimediaFisica3 .dz-preview .dz-details .dz-filename span,
    .multimediaFisica3 .dz-preview .dz-details .dz-size span {
        background-color: rgba(255, 255, 255, 0.4);
        padding: 0 0.4em;
        border-radius: 3px;
    }

    .multimediaFisica3 .dz-preview:hover .dz-image img {
        -webkit-transform: scale(1.05, 1.05);
        -moz-transform: scale(1.05, 1.05);
        -ms-transform: scale(1.05, 1.05);
        -o-transform: scale(1.05, 1.05);
        transform: scale(1.05, 1.05);
        -webkit-filter: blur(8px);
        filter: blur(8px);
    }

    .multimediaFisica3 .dz-preview .dz-image {
        border-radius: 20px;
        overflow: hidden;
        width: 120px;
        height: 120px;
        position: relative;
        display: block;
        z-index: 10;
    }

    .multimediaFisica3 .dz-preview .dz-image img {
        display: block;
    }

    .multimediaFisica3 .dz-preview.dz-success .dz-success-mark {
        -webkit-animation: passing-through 3s cubic-bezier(0.77, 0, 0.175, 1);
        -moz-animation: passing-through 3s cubic-bezier(0.77, 0, 0.175, 1);
        -ms-animation: passing-through 3s cubic-bezier(0.77, 0, 0.175, 1);
        -o-animation: passing-through 3s cubic-bezier(0.77, 0, 0.175, 1);
        animation: passing-through 3s cubic-bezier(0.77, 0, 0.175, 1);
    }

    .multimediaFisica3 .dz-preview.dz-error .dz-error-mark {
        opacity: 1;
        -webkit-animation: slide-in 3s cubic-bezier(0.77, 0, 0.175, 1);
        -moz-animation: slide-in 3s cubic-bezier(0.77, 0, 0.175, 1);
        -ms-animation: slide-in 3s cubic-bezier(0.77, 0, 0.175, 1);
        -o-animation: slide-in 3s cubic-bezier(0.77, 0, 0.175, 1);
        animation: slide-in 3s cubic-bezier(0.77, 0, 0.175, 1);
    }

    .multimediaFisica3 .dz-preview .dz-success-mark,
    .multimediaFisica3 .dz-preview .dz-error-mark {
        pointer-events: none;
        opacity: 0;
        z-index: 500;
        position: absolute;
        display: block;
        top: 50%;
        left: 50%;
        margin-left: -27px;
        margin-top: -27px;
    }

    .multimediaFisica3 .dz-preview .dz-success-mark svg,
    .multimediaFisica3 .dz-preview .dz-error-mark svg {
        display: block;
        width: 54px;
        height: 54px;
    }

    .multimediaFisica3 .dz-preview.dz-processing .dz-progress {
        opacity: 1;
        -webkit-transition: all 0.2s linear;
        -moz-transition: all 0.2s linear;
        -ms-transition: all 0.2s linear;
        -o-transition: all 0.2s linear;
        transition: all 0.2s linear;
    }

    .multimediaFisica3 .dz-preview.dz-complete .dz-progress {
        opacity: 0;
        -webkit-transition: opacity 0.4s ease-in;
        -moz-transition: opacity 0.4s ease-in;
        -ms-transition: opacity 0.4s ease-in;
        -o-transition: opacity 0.4s ease-in;
        transition: opacity 0.4s ease-in;
    }

    .multimediaFisica3 .dz-preview:not(.dz-processing) .dz-progress {
        -webkit-animation: pulse 6s ease infinite;
        -moz-animation: pulse 6s ease infinite;
        -ms-animation: pulse 6s ease infinite;
        -o-animation: pulse 6s ease infinite;
        animation: pulse 6s ease infinite;
    }

    .multimediaFisica3 .dz-preview .dz-progress {
        opacity: 1;
        z-index: 1000;
        pointer-events: none;
        position: absolute;
        height: 16px;
        left: 50%;
        top: 50%;
        margin-top: -8px;
        width: 80px;
        margin-left: -40px;
        background: rgba(255, 255, 255, 0.9);
        -webkit-transform: scale(1);
        border-radius: 8px;
        overflow: hidden;
    }

    .multimediaFisica3 .dz-preview .dz-progress .dz-upload {
        background: #333;
        background: linear-gradient(to bottom, #666, #444);
        position: absolute;
        top: 0;
        left: 0;
        bottom: 0;
        width: 0;
        -webkit-transition: width 300ms ease-in-out;
        -moz-transition: width 300ms ease-in-out;
        -ms-transition: width 300ms ease-in-out;
        -o-transition: width 300ms ease-in-out;
        transition: width 300ms ease-in-out;
    }

    .multimediaFisica3 .dz-preview.dz-error .dz-error-message {
        display: block;
    }

    .multimediaFisica3 .dz-preview.dz-error:hover .dz-error-message {
        opacity: 1;
        pointer-events: auto;
    }

    .multimediaFisica3 .dz-preview .dz-error-message {
        pointer-events: none;
        z-index: 1000;
        position: absolute;
        display: block;
        display: none;
        opacity: 0;
        -webkit-transition: opacity 0.3s ease;
        -moz-transition: opacity 0.3s ease;
        -ms-transition: opacity 0.3s ease;
        -o-transition: opacity 0.3s ease;
        transition: opacity 0.3s ease;
        border-radius: 8px;
        font-size: 13px;
        top: 130px;
        left: -10px;
        width: 140px;
        background: #be2626;
        background: linear-gradient(to bottom, #be2626, #a92222);
        padding: 0.5em 1.2em;
        color: white;
    }

    .multimediaFisica3 .dz-preview .dz-error-message:after {
        content: '';
        position: absolute;
        top: -6px;
        left: 64px;
        width: 0;
        height: 0;
        border-left: 6px solid transparent;
        border-right: 6px solid transparent;
        border-bottom: 6px solid #be2626;
    }
</style>
<div class="container-fluid">
    <!--begin::Card-->
    <div class="card card-custom">
        <div class="card-header flex-wrap py-5">
            <div class="card-title">
                <h3 class="card-label">
                    Configuraci&oacute;n de Cursos
                </h3>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-separate table-head-custom table-checkable" id="tbl_configuracion_curso">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Nombre Curso</th>
                        <th>Imagen</th>
                        <th>Nota Aprobacion</th>
                        <th>fecha inicial</th>
                        <th>fecha final</th>
                        <th>Carga Horaria</th>
                        <th>Fecha Certificacion</th>
                        <th>Fecha Creacion</th>
                        <th>Posx Nombre</th>
                        <th>Posy Nombre</th>
                        <th>Posx Texto</th>
                        <th>Posy Texto</th>
                        <th>Posx Curso</th>
                        <th>Posy Curso</th>
                        <th>Posx qr</th>
                        <th>Posy qr</th>
                        <th>Posx tipo participacion</th>
                        <th>posy tipo participacion</th>
                        <th>fuente pdf</th>
                        <th>tamanio titulo</th>
                        <th>tamanio subtitulo</th>
                        <th>Tamanio texto</th>
                        <th>Color Nombre Participante</th>
                        <th>Color Subtitulo</th>
                        <th>Detalle Curso</th>
                        <th>Horarios</th>
                        <th>url_pdf</th>
                        <th>Banner Curso</th>
                        <th>N&uacute;mero Referencia</th>
                        <th>Inversi&oacute;n</th>
                        <th>Descuento</th>
                        <th>Fecha Inicio Descuento</th>
                        <th>Fecha Fin Descuento</th>
                        <!-- <th>Posx imagen personalizado</th>
                        <th>Posy imagen personalizado</th>
                        <th>Imprimir Subtitulo</th> -->
                        <th>Subtitulo</th>
                        <th>Estado Curso</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
            </table>

        </div>
    </div>
</div>

<div class="modal fade" id="modal_editar_conf" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title-conf"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="actualizar_configuracion" method="post" enctype="multipart/form-data">
                    <!-- imagen curso -->
                    <div class="form-group row">
                        <div class="col-lg-6">
                            <h6>Imagen del certificado</h6>
                            <div class="multimediaFisica needsclick dz-clickable">

                                <div class="dz-message needsclick">

                                    Arrastrar o dar click para subir imagen del certificado.

                                </div>

                            </div>
                        </div>
                        <div class="col-lg-6">
                            <h6>Banner del Curso</h6>
                            <div class="multimediaFisica1 needsclick dz-clickable">

                                <div class="dz-message needsclick">

                                    Arrastrar o dar click para subir imagen del banner del curso.

                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-3">
                            <label for="nota_aprobacion">Nota Aprobaci&oacute;n <span class="text-danger">(*)</span>: </label>
                            <input type="number" class="form-control" id="nota_aprobacion" name="nota_aprobacion" onkeypress="return event.charCode >= 48 && event.charCode <= 57" />
                            <span class="form-text text-muted">Ingrese la nota de aprobacion</span>
                        </div>
                        <div class="col-lg-3">
                            <label for="fecha_inicial">Fecha Inicio: </label>
                            <input type="date" class="form-control" id="fecha_inicial" name="fecha_inicial" />
                            <span class="form-text text-muted">Ingrese fecha de Inicio del curso</span>
                        </div>
                        <div class="col-lg-3">
                            <label for="fecha_final">Fecha Final: </label>
                            <input type="date" class="form-control" id="fecha_final" name="fecha_final" />
                            <span class="form-text text-muted">Ingrese fecha Fin del curso</span>
                        </div>
                        <div class="col-lg-3">
                            <label for="carga_horaria">Carga Horaria <span class="text-danger">(*)</span>:</label>
                            <input type="number" class="form-control" id="carga_horaria" name="carga_horaria" onkeypress="return event.charCode >= 48 && event.charCode <= 57" />
                            <span class="form-text text-muted">Ingrese carga horaria del curso</span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-3">
                            <label for="fecha_certificacion">Fecha Certificaci&oacute;n <span class="text-danger">(*)</span>: </label>
                            <input type="datetime" class="form-control" id="fecha_certificacion" name="fecha_certificacion" />
                            <span class="form-text text-muted">Ingrese la fecha de certificacion curso</span>
                        </div>

                        <div class="col-lg-3">
                            <label for="fecha_creacion">Fecha Creaci&oacute;n: </label>
                            <input type="datetime" class="form-control" id="fecha_creacion" name="fecha_creacion" />
                            <span class="form-text text-muted">Ingrese la fecha de creacion curso</span>
                        </div>

                        <div class="col-lg-3">
                            <label for="posx_nombre_participante">X nombre participante <span class="text-danger">(*)</span>:</label>
                            <input type="number" class="form-control" id="posx_nombre_participante" name="posx_nombre_participante" onkeypress="return event.charCode >= 48 && event.charCode <= 57" />
                            <span class="form-text text-muted">Posicion x nombre del participante</span>
                        </div>

                        <div class="col-lg-3">
                            <label for="posy_nombre_participante">Y nombre participante <span class="text-danger">(*)</span>:</label>
                            <input type="number" class="form-control" id="posy_nombre_participante" name="posy_nombre_participante" onkeypress="return event.charCode >= 48 && event.charCode <= 57" />
                            <span class="form-text text-muted">Posicion y nombre del participante</span>
                        </div>
                        <input type="hidden" id="id_configuracion_curso" name="id_configuracion_curso" />
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-3">
                            <label for="posx_bloque_texto">X bloque texto <span class="text-danger">(*)</span>:</label>
                            <input type="number" class="form-control" id="posx_bloque_texto" name="posx_bloque_texto" onkeypress="return event.charCode >= 48 && event.charCode <= 57" />
                            <span class="form-text text-muted">Posicion x bloque texto</span>
                        </div>
                        <div class="col-lg-3">
                            <label for="posy_bloque_texto">Y bloque texto <span class="text-danger">(*)</span>:</label>
                            <input type="number" class="form-control" id="posy_bloque_texto" name="posy_bloque_texto" onkeypress="return event.charCode >= 48 && event.charCode <= 57" />
                            <span class="form-text text-muted">Posicion y bloque texto</span>
                        </div>
                        <div class="col-lg-3">
                            <label for="posx_nombre_curso">X nombre curso:</label>
                            <input type="number" class="form-control" id="posx_nombre_curso" name="posx_nombre_curso" onkeypress="return event.charCode >= 48 && event.charCode <= 57" />
                            <span class="form-text text-muted">Posicion x nombre curso</span>
                        </div>
                        <div class="col-lg-3">
                            <label for="posy_nombre_curso">Y nombre curso:</label>
                            <input type="number" class="form-control" id="posy_nombre_curso" name="posy_nombre_curso" onkeypress="return event.charCode >= 48 && event.charCode <= 57" />
                            <span class="form-text text-muted">Posicion y nombre curso</span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-3">
                            <label for="posx_qr">X qr <span class="text-danger">(*)</span>:</label>
                            <input type="number" class="form-control" id="posx_qr" name="posx_qr" onkeypress="return event.charCode >= 48 && event.charCode <= 57" />
                            <span class="form-text text-muted">Posicion x QR</span>
                        </div>
                        <div class="col-lg-3">
                            <label for="posy_qr">Y qr <span class="text-danger">(*)</span>:</label>
                            <input type="number" class="form-control" id="posy_qr" name="posy_qr" onkeypress="return event.charCode >= 48 && event.charCode <= 57" />
                            <span class="form-text text-muted">Posicion y QR</span>
                        </div>
                        <div class="col-lg-3">
                            <label for="posx_tipo_participacion">X tipo participaci&oacute;n:</label>
                            <input type="number" class="form-control" id="posx_tipo_participacion" name="posx_tipo_participacion" onkeypress="return event.charCode >= 48 && event.charCode <= 57" />
                            <span class="form-text text-muted">Posicion x tipo participacion</span>
                        </div>
                        <div class="col-lg-3">
                            <label for="posy_tipo_participacion">Y tipo participaci&oacute;n:</label>
                            <input type="number" class="form-control" id="posy_tipo_participacion" name="posy_tipo_participacion" onkeypress="return event.charCode >= 48 && event.charCode <= 57" />
                            <span class="form-text text-muted">Posicion y tipo participacion</span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-3">
                            <label for="fuente_pdf">Fuente PDF</label>
                            <input type="text" class="form-control" id="fuente_pdf" name="fuente_pdf" />
                            <span class="form-text text-muted">Ingrese fuente pdf</span>
                        </div>
                        <div class="col-lg-3">
                            <label for="tamano_titulo">Tamano Titulo <span class="text-danger">(*)</span>:</label>
                            <input type="number" class="form-control" id="tamano_titulo" name="tamano_titulo" onkeypress="return event.charCode >= 48 && event.charCode <= 57" />
                            <span class="form-text text-muted">Ingrese tamanio titulo</span>
                        </div>
                        <div class="col-lg-3">
                            <label for="tamano_subtitulo">Tamano subtitulo <span class="text-danger">(*)</span>:</label>
                            <input type="number" class="form-control" id="tamano_subtitulo" name="tamano_subtitulo" onkeypress="return event.charCode >= 48 && event.charCode <= 57" />
                            <span class="form-text text-muted">Ingrese tamanio subtitulo</span>
                        </div>
                        <div class="col-lg-3">
                            <label for="tamano_texto">Tamano texto <span class="text-danger">(*)</span>:</label>
                            <input type="number" class="form-control" id="tamano_texto" name="tamano_texto" onkeypress="return event.charCode >= 48 && event.charCode <= 57" />
                            <span class="form-text text-muted">Ingrese tamanio texto</span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label for="color_nombre_participante">Color nombre participante <span class="text-danger">(*)</span>:</label>
                            <input type="color" class="form-control" id="color_nombre_participante" name="color_nombre_participante" />
                            <span class="form-text text-muted">Seleccione color nombre participante</span>
                        </div>
                        <div class="col-lg-6">
                            <label for="color_subtitulo">Color subtitulo <span class="text-danger">(*)</span>:</label>
                            <input type="color" class="form-control" id="color_subtitulo" name="color_subtitulo" />
                            <span class="form-text text-muted">Seleccione color para tipo de participacion y fecha</span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-12">
                            <label for="detalle_curso">Detalle Curso <span class="text-danger">(*)</span>:</label>
                            <textarea name="detalle_curso" id="detalle_curso" rows="2" class="form-control"></textarea>
                            <span class="form-text text-muted">Ingrese detalle del curso</span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-12">
                            <label for="horario">Horarios <span class="text-danger">(*)</span>:</label>
                            <textarea name="horario" id="horario" rows="1" class="form-control" placeholder="LUNES, MARTES Y MIERCOLES 7P.M."></textarea>
                            <span class="form-text text-muted">Ingrese los horarios de clases</span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-4">
                            <label for="inversion">Inversi&oacute;n <span class="text-danger">(*)</span>:</label>
                            <input type="number" class="form-control" id="inversion" name="inversion" />
                            <span class="form-text text-muted">Ingrese la inversi&oacute;n del curso</span>
                        </div>
                        <div class="col-lg-4">
                            <label for="url_pdf">URL pdf <span class="text-danger">(*)</span>:</label>
                            <input type="file" class="form-control" id="url_pdf" name="url_pdf" accept=".pdf, .doc, .docx" />
                            <span class="form-text text-muted">Suba descripcion del curso formato pdf del curso</span>
                        </div>
                        <div class="col-lg-4">
                            <label for="celular_referencia">Numero de Referencia <span class="text-danger">(*)</span>:</label>
                            <input type="text" class="form-control" id="celular_referencia" name="celular_referencia" />
                            <span class="form-text text-muted">Ingrese numero referencia del curso</span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-4">
                            <label for="descuento">Descuento <span class="text-danger">(*)</span>:</label>
                            <input type="number" class="form-control" id="descuento" name="descuento" />
                            <span class="form-text text-muted">Ingrese el descuento del curso</span>
                        </div>
                        <div class="col-lg-4">
                            <label for="fecha_inicio_descuento">Fecha Inicio Descuento <span class="text-danger">(*)</span>:</label>
                            <input type="date" class="form-control" id="fecha_inicio_descuento" name="fecha_inicio_descuento" />
                            <span class="form-text text-muted">Ingrese la fecha de inicio del descuento</span>
                        </div>
                        <div class="col-lg-4">
                            <label for="fecha_fin_descuento">Fecha Fin Descuento <span class="text-danger">(*)</span>:</label>
                            <input type="date" class="form-control" id="fecha_fin_descuento" name="fecha_fin_descuento" />
                            <span class="form-text text-muted">Ingrese la fecha fin del descuento</span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-3">
                            <label for="fecha_inicio_lanzamiento">Fecha Inicio Lanzamiento <span class="text-danger">(*)</span>:</label>
                            <input type="date" class="form-control" id="fecha_inicio_lanzamiento" name="fecha_inicio_lanzamiento" />
                            <span class="form-text text-muted">Ingrese la fecha inicio del lanzamiento del curso</span>
                        </div>
                        <div class="col-lg-3">
                            <label for="fecha_fin_lanzamiento">Fecha Fin Lanzamiento <span class="text-danger">(*)</span>:</label>
                            <input type="date" class="form-control" id="fecha_fin_lanzamiento" name="fecha_fin_lanzamiento" />
                            <span class="form-text text-muted">Ingrese la fecha fin del lanzamiento del curso</span>
                        </div>

                        <div class="col-lg-3">
                            <label for="proximo_curso">Próximo Curso <span class="text-danger">(*)</span>:</label>
                            <select name="proximo_curso" id="proximo_curso" class="form-control">
                                <option value="no">no</option>
                                <option value="si">si</option>
                            </select>
                            <span class="form-text text-muted">próximo curso</span>
                        </div>

                        <div class="col-lg-3">
                            <label for="orientacion">Orientación certificado <span class="text-danger">(*)</span>:</label>
                            <select name="orientacion" id="orientacion" class="form-control">
                                <option value="horizontal">horizontal</option>
                                <option value="vertical">vertical</option>
                            </select>
                            <span class="form-text text-muted">Horientación del certificado</span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-3">
                            <button type="submit" class="btn btn-info btn-block">
                                <i class="nav-icon la la-edit"></i>
                                Actualizar
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_agregar_imagen_per" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title-agregar"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="agregar_img_personalizado" method="post" enctype="multipart/form-data">
                    <!-- imagen curso -->
                    <input type="hidden" name="id" id="id">
                    <div class="form-group row">
                        <div class="col-lg-12">
                            <h6>Imagen del certificado</h6>
                            <div class="multimediaFisica3 needsclick dz-clickable">

                                <div class="dz-message needsclick">

                                    Arrastrar o dar click para subir imagen del certificado.

                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="form-group row">

                        <div class="col-lg-6">
                            <label for="posx_imagen_personalizado">X imagen personalizado <span class="text-danger">(*)</span>:</label>
                            <input type="number" class="form-control" id="posx_imagen_personalizado" name="posx_imagen_personalizado" onkeypress="return event.charCode >= 48 && event.charCode <= 57" />
                            <span class="form-text text-muted">Posicion x imagen personalizado</span>
                        </div>

                        <div class="col-lg-6">
                            <label for="posy_imagen_personalizado">Y imagen personalizado <span class="text-danger">(*)</span>:</label>
                            <input type="number" class="form-control" id="posy_imagen_personalizado" name="posy_imagen_personalizado" onkeypress="return event.charCode >= 48 && event.charCode <= 57" />
                            <span class="form-text text-muted">Posicion y imagen personalizado</span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-4">
                            <label for="imprimir_subtitulo">Imprimir imprimir_subtitulo: </label><br>
                            <input type="checkbox" id="imprimir_subtitulo" name="imprimir_subtitulo" data-on-color="primary" />
                        </div>
                        <div class="col-lg-8">
                            <label for="subtitulo">Subtítulo: </label>
                            <input type="text" class="form-control" id="subtitulo" name="subtitulo" />
                            <span class="form-text text-muted">Ingrese subtítulo</span>
                        </div>
                    </div>


                    <div class="form-group row">
                        <div class="col-lg-3">
                            <button type="submit" class="btn btn-info btn-block">
                                <i class="nav-icon la la-edit"></i>
                                Guardar
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>