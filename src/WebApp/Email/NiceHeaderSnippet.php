<?php

namespace WebApp\Email;

class NiceHeaderSnippet extends AbstractSnippet {

	public function __construct() {
		$this->textColor      = '#05164D';
		$this->headerColor    = '#05164D';
	}

	protected function getHtml($processor) {
		$language    = $processor->language;
		$textColor   = $this->textColor;
		$headerColor = $this->headerColor;
		$rc = <<<EOH
<html xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:w="urn:schemas-microsoft-com:office:word" xmlns:m="http://schemas.microsoft.com/office/2004/12/omml" xmlns="http://www.w3.org/TR/REC-html40">
<head>
    <style type="text/css">
        li.ImprintUniqueID,
        div.ImprintUniqueID,
        table.ImprintUniqueIDTable,
        p.ImprintUniqueID {
            margin: 0;
        }
    </style>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="Generator" content="technicalguru/webapp" />
    <!--[if !mso]><style>v\:* {behavior:url(#default#VML);}
o\:* {behavior:url(#default#VML);}
w\:* {behavior:url(#default#VML);}
.shape {behavior:url(#default#VML);}
</style><![endif]-->
    <style>
        <!--
        /* Font Definitions */
        /* latin-ext */
        @font-face {
          font-family: 'Nunito';
          font-style: italic;
          font-weight: 200;
          font-display: swap;
          src: local('Nunito ExtraLight Italic'), local('Nunito-ExtraLightItalic'), url(https://fonts.gstatic.com/s/nunito/v13/XRXQ3I6Li01BKofIMN5MZ9vEUT8_DQ.woff2) format('woff2');
          unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
        }
        /* latin */
        @font-face {
          font-family: 'Nunito';
          font-style: italic;
          font-weight: 200;
          font-display: swap;
          src: local('Nunito ExtraLight Italic'), local('Nunito-ExtraLightItalic'), url(https://fonts.gstatic.com/s/nunito/v13/XRXQ3I6Li01BKofIMN5MZ9vKUT8.woff2) format('woff2');
          unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }
        /* latin-ext */
        @font-face {
          font-family: 'Nunito';
          font-style: italic;
          font-weight: 300;
          font-display: swap;
          src: local('Nunito Light Italic'), local('Nunito-LightItalic'), url(https://fonts.gstatic.com/s/nunito/v13/XRXQ3I6Li01BKofIMN4oZNvEUT8_DQ.woff2) format('woff2');
          unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
        }
        /* latin */
        @font-face {
          font-family: 'Nunito';
          font-style: italic;
          font-weight: 300;
          font-display: swap;
          src: local('Nunito Light Italic'), local('Nunito-LightItalic'), url(https://fonts.gstatic.com/s/nunito/v13/XRXQ3I6Li01BKofIMN4oZNvKUT8.woff2) format('woff2');
          unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }
        /* latin-ext */
        @font-face {
          font-family: 'Nunito';
          font-style: italic;
          font-weight: 400;
          font-display: swap;
          src: local('Nunito Italic'), local('Nunito-Italic'), url(https://fonts.gstatic.com/s/nunito/v13/XRXX3I6Li01BKofIMNaNRs71cA.woff2) format('woff2');
          unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
        }
        /* latin */
        @font-face {
          font-family: 'Nunito';
          font-style: italic;
          font-weight: 400;
          font-display: swap;
          src: local('Nunito Italic'), local('Nunito-Italic'), url(https://fonts.gstatic.com/s/nunito/v13/XRXX3I6Li01BKofIMNaDRs4.woff2) format('woff2');
          unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }
        /* latin-ext */
        @font-face {
          font-family: 'Nunito';
          font-style: italic;
          font-weight: 600;
          font-display: swap;
          src: local('Nunito SemiBold Italic'), local('Nunito-SemiBoldItalic'), url(https://fonts.gstatic.com/s/nunito/v13/XRXQ3I6Li01BKofIMN5cYtvEUT8_DQ.woff2) format('woff2');
          unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
        }
        /* latin */
        @font-face {
          font-family: 'Nunito';
          font-style: italic;
          font-weight: 600;
          font-display: swap;
          src: local('Nunito SemiBold Italic'), local('Nunito-SemiBoldItalic'), url(https://fonts.gstatic.com/s/nunito/v13/XRXQ3I6Li01BKofIMN5cYtvKUT8.woff2) format('woff2');
          unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }
        /* latin-ext */
        @font-face {
          font-family: 'Nunito';
          font-style: italic;
          font-weight: 700;
          font-display: swap;
          src: local('Nunito Bold Italic'), local('Nunito-BoldItalic'), url(https://fonts.gstatic.com/s/nunito/v13/XRXQ3I6Li01BKofIMN44Y9vEUT8_DQ.woff2) format('woff2');
          unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
        }
        /* latin */
        @font-face {
          font-family: 'Nunito';
          font-style: italic;
          font-weight: 700;
          font-display: swap;
          src: local('Nunito Bold Italic'), local('Nunito-BoldItalic'), url(https://fonts.gstatic.com/s/nunito/v13/XRXQ3I6Li01BKofIMN44Y9vKUT8.woff2) format('woff2');
          unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }
        /* latin-ext */
        @font-face {
          font-family: 'Nunito';
          font-style: italic;
          font-weight: 800;
          font-display: swap;
          src: local('Nunito ExtraBold Italic'), local('Nunito-ExtraBoldItalic'), url(https://fonts.gstatic.com/s/nunito/v13/XRXQ3I6Li01BKofIMN4kYNvEUT8_DQ.woff2) format('woff2');
          unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
        }
        /* latin */
        @font-face {
          font-family: 'Nunito';
          font-style: italic;
          font-weight: 800;
          font-display: swap;
          src: local('Nunito ExtraBold Italic'), local('Nunito-ExtraBoldItalic'), url(https://fonts.gstatic.com/s/nunito/v13/XRXQ3I6Li01BKofIMN4kYNvKUT8.woff2) format('woff2');
          unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }
        /* latin-ext */
        @font-face {
          font-family: 'Nunito';
          font-style: italic;
          font-weight: 900;
          font-display: swap;
          src: local('Nunito Black Italic'), local('Nunito-BlackItalic'), url(https://fonts.gstatic.com/s/nunito/v13/XRXQ3I6Li01BKofIMN4AYdvEUT8_DQ.woff2) format('woff2');
          unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
        }
        /* latin */
        @font-face {
          font-family: 'Nunito';
          font-style: italic;
          font-weight: 900;
          font-display: swap;
          src: local('Nunito Black Italic'), local('Nunito-BlackItalic'), url(https://fonts.gstatic.com/s/nunito/v13/XRXQ3I6Li01BKofIMN4AYdvKUT8.woff2) format('woff2');
          unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }
        /* latin-ext */
        @font-face {
          font-family: 'Nunito';
          font-style: normal;
          font-weight: 200;
          font-display: swap;
          src: local('Nunito ExtraLight'), local('Nunito-ExtraLight'), url(https://fonts.gstatic.com/s/nunito/v13/XRXW3I6Li01BKofA-seUb-vISTs.woff2) format('woff2');
          unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
        }
        /* latin */
        @font-face {
          font-family: 'Nunito';
          font-style: normal;
          font-weight: 200;
          font-display: swap;
          src: local('Nunito ExtraLight'), local('Nunito-ExtraLight'), url(https://fonts.gstatic.com/s/nunito/v13/XRXW3I6Li01BKofA-seUYevI.woff2) format('woff2');
          unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }
        /* latin-ext */
        @font-face {
          font-family: 'Nunito';
          font-style: normal;
          font-weight: 300;
          font-display: swap;
          src: local('Nunito Light'), local('Nunito-Light'), url(https://fonts.gstatic.com/s/nunito/v13/XRXW3I6Li01BKofAnsSUb-vISTs.woff2) format('woff2');
          unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
        }
        /* latin */
        @font-face {
          font-family: 'Nunito';
          font-style: normal;
          font-weight: 300;
          font-display: swap;
          src: local('Nunito Light'), local('Nunito-Light'), url(https://fonts.gstatic.com/s/nunito/v13/XRXW3I6Li01BKofAnsSUYevI.woff2) format('woff2');
          unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }
        /* latin-ext */
        @font-face {
          font-family: 'Nunito';
          font-style: normal;
          font-weight: 400;
          font-display: swap;
          src: local('Nunito Regular'), local('Nunito-Regular'), url(https://fonts.gstatic.com/s/nunito/v13/XRXV3I6Li01BKofIO-aBXso.woff2) format('woff2');
          unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
        }
        /* latin */
        @font-face {
          font-family: 'Nunito';
          font-style: normal;
          font-weight: 400;
          font-display: swap;
          src: local('Nunito Regular'), local('Nunito-Regular'), url(https://fonts.gstatic.com/s/nunito/v13/XRXV3I6Li01BKofINeaB.woff2) format('woff2');
          unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }
        /* latin-ext */
        @font-face {
          font-family: 'Nunito';
          font-style: normal;
          font-weight: 600;
          font-display: swap;
          src: local('Nunito SemiBold'), local('Nunito-SemiBold'), url(https://fonts.gstatic.com/s/nunito/v13/XRXW3I6Li01BKofA6sKUb-vISTs.woff2) format('woff2');
          unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
        }
        /* latin */
        @font-face {
          font-family: 'Nunito';
          font-style: normal;
          font-weight: 600;
          font-display: swap;
          src: local('Nunito SemiBold'), local('Nunito-SemiBold'), url(https://fonts.gstatic.com/s/nunito/v13/XRXW3I6Li01BKofA6sKUYevI.woff2) format('woff2');
          unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }
        /* latin-ext */
        @font-face {
          font-family: 'Nunito';
          font-style: normal;
          font-weight: 700;
          font-display: swap;
          src: local('Nunito Bold'), local('Nunito-Bold'), url(https://fonts.gstatic.com/s/nunito/v13/XRXW3I6Li01BKofAjsOUb-vISTs.woff2) format('woff2');
          unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
        }
        /* latin */
        @font-face {
          font-family: 'Nunito';
          font-style: normal;
          font-weight: 700;
          font-display: swap;
          src: local('Nunito Bold'), local('Nunito-Bold'), url(https://fonts.gstatic.com/s/nunito/v13/XRXW3I6Li01BKofAjsOUYevI.woff2) format('woff2');
          unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }
        /* latin-ext */
        @font-face {
          font-family: 'Nunito';
          font-style: normal;
          font-weight: 800;
          font-display: swap;
          src: local('Nunito ExtraBold'), local('Nunito-ExtraBold'), url(https://fonts.gstatic.com/s/nunito/v13/XRXW3I6Li01BKofAksCUb-vISTs.woff2) format('woff2');
          unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
        }
        /* latin */
        @font-face {
          font-family: 'Nunito';
          font-style: normal;
          font-weight: 800;
          font-display: swap;
          src: local('Nunito ExtraBold'), local('Nunito-ExtraBold'), url(https://fonts.gstatic.com/s/nunito/v13/XRXW3I6Li01BKofAksCUYevI.woff2) format('woff2');
          unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }
        /* latin-ext */
        @font-face {
          font-family: 'Nunito';
          font-style: normal;
          font-weight: 900;
          font-display: swap;
          src: local('Nunito Black'), local('Nunito-Black'), url(https://fonts.gstatic.com/s/nunito/v13/XRXW3I6Li01BKofAtsGUb-vISTs.woff2) format('woff2');
          unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
        }
        /* latin */
        @font-face {
          font-family: 'Nunito';
          font-style: normal;
          font-weight: 900;
          font-display: swap;
          src: local('Nunito Black'), local('Nunito-Black'), url(https://fonts.gstatic.com/s/nunito/v13/XRXW3I6Li01BKofAtsGUYevI.woff2) format('woff2');
          unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }
        
        /* Style Definitions */
        p.MsoNormal,
        li.MsoNormal,
        div.MsoNormal {
            margin: 0cm;
            margin-bottom: .0001pt;
            line-height: normal;
            font-size: 16px;
            font-family: Nunito, sans-serif;
            color: windowtext;
            mso-fareast-language: EN-US;
        }
        
        h1 {
            mso-style-priority: 9;
            mso-style-link: "Überschrift 2 Zchn";
            margin: 0cm;
            margin-bottom: 10px;
            line-height: 1.2;
            font-size: 1.5rem;
            font-family: Nunito, sans-serif;
            color: $headerColor;
            font-weight: bold;
        }
        
        h2 {
            mso-style-priority: 9;
            mso-style-link: "Überschrift 2 Zchn";
            margin: 0cm;
            margin-bottom: 8px;
            line-height: 1.1;
            font-size: 1.3rem;
            font-family: Nunito, sans-serif;
            color: $headerColor;
            font-weight: bold;
        }
        
        a:link,
        span.MsoHyperlink {
            mso-style-priority: 99;
            color: #0563C1;
            text-decoration: underline;
        }
        
        a:visited,
        span.MsoHyperlinkFollowed {
            mso-style-priority: 99;
            color: #954F72;
            text-decoration: underline;
        }
        
        p {
            mso-style-priority: 99;
            margin: 0cm;
            margin-bottom: .0001pt;
            font-family: Nunito, sans-serif;
            color: $textColor;
        }
        
        p.msonormal0,
        li.msonormal0,
        div.msonormal0 {
            mso-style-name: msonormal;
            mso-style-priority: 99;
            margin: 0cm;
            margin-bottom: .0001pt;
            font-family: Nunito, sans-serif;
            color: $textColor;
        }
        
        p.paragraph,
        li.paragraph,
        div.paragraph {
            mso-style-name: paragraph;
            mso-style-priority: 99;
            margin: 0cm;
            margin-bottom: .0001pt;
            font-family: Nunito, sans-serif;
            color: windowtext;
        }
        
        span.E-MailFormatvorlage21 {
            mso-style-type: personal;
            font-family: Nunito, sans-serif;
            color: windowtext;
        }
        
        span.normaltextrun1 {
            mso-style-name: normaltextrun1;
        }
        
        span.E-MailFormatvorlage23 {
            mso-style-type: personal;
            font-family: Nunito, sans-serif;
            mso-fareast-language: DE;
        }
        
        span.E-MailFormatvorlage25 {
            mso-style-type: personal-reply;
            font-family: Nunito, sans-serif;
            color: #1F497D;
        }
        
        .MsoChpDefault {
            mso-style-type: export-only;
            font-size: 10.0pt;
        }
        
        @page WordSection1 {
            size: 612.0pt 792.0pt;
            margin: 70.85pt 70.85pt 2.0cm 70.85pt;
        }
        
        div.WordSection1 {
            page: WordSection1;
        }
        
        -->
    </style>
    <!--[if gte mso 9]><xml>
<o:shapedefaults v:ext="edit" spidmax="1028" />
</xml><![endif]-->
    <!--[if gte mso 9]><xml>
<o:shapelayout v:ext="edit">
<o:idmap v:ext="edit" data="1" />
</o:shapelayout></xml><![endif]-->
</head>

<body lang="$language" link="#0563C1" vlink="#954F72">
    <p class="ImprintUniqueID">
        <p class="ImprintUniqueID">
            <div class="WordSection1">
                <div align="center">
                    <table class="MsoNormalTable" border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100%;background:#F0F0F0;border-collapse:collapse;">
                        <tbody>
                            <tr>
                                <td valign="top" style="padding:0;">
                                    <div align="center">
                                        <table class="MsoNormalTable" border="0" cellspacing="0" cellpadding="0" width="0" style="background:white;border-collapse:collapse;">
                                            <tbody>
                                                <tr>
                                                    <td valign="top" style="padding:0;">
                                                        <div align="center">
                                                            <table class="MsoNormalTable" border="0" cellspacing="0" cellpadding="0" width="0" style="background:white;border-collapse:collapse;">
                                                                <tbody>
                                                                    <tr>
                                                                        <td valign="top" style="padding:0;">
                                                                            <p class="MsoNormal" align="center" style="text-align:center"><span style="font-family:Nunito,sans-serif;mso-fareast-language:DE;"><!-- an image maybe here --></span><span style="font-size:16px;font-family:Nunito,sans-serif;"><o:p></o:p></span></p>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td valign="top" style="padding:0;">
                                                        <div align="center">
                                                            <table class="MsoNormalTable" border="0" cellspacing="0" cellpadding="0" width="0" style="border-collapse:collapse;overflow:hidden;">
                                                                <tbody>
                                                                    <tr>
                                                                        <td valign="top" style="background:white;padding:0;">
                                                                            <table class="MsoNormalTable" border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100%;border-collapse:collapse;">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td valign="top" style="padding:16px;font-size:16px;font-family:Nunito,sans-serif;">
											<!-- ******** BEGIN CONTENT ********* -->
EOH;
		return $rc;
	}

	protected function getText($processor) {
		return '';
	}

}
