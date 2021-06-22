<?php

namespace WebApp\Email;

use TgI18n\I18N;

class NiceFooterSnippet extends AbstractSnippet {

	protected function getHtml($processor, $params) {
		$language    = $processor->language;
		$attention   = I18N::_(array('de' => 'Achtung!', 'en' => 'Attention!'), $language);
		$disclaimer  = I18N::_(array(
			'de' => 'Bitte antworte nicht direkt auf diese Nachricht. Diese Nachricht wurde automatisch erzeugt und dient nur zu Deiner Information.',
			'en' => 'Please do not reply to this e-mail. This message was generated automatically and was sent for your information only.',
		), $language);

		$rc = <<<EOT
											<!-- ******** END CONTENT ********* -->

                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
									    <!-- BEGIN FOOTER -->
                                                                            <p class="MsoNormal"><span style="font-family:Arial,Helvetica,sans-serif,Nunito;display:none;"><o:p>&nbsp;</o:p></span></p>
                                                                            <table class="MsoNormalTable" border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100%;background:#E6E6E6;border-collapse:collapse;">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td style="padding:.75pt;">
                                                                                            <p class="MsoNormal"><span style="font-family:Arial,Helvetica,sans-serif,Nunito;">&nbsp;</span><span style="font-size:12.0pt;font-family:Arial,Helvetica,sans-serif,Nunito;"><o:p></o:p></span></p>
                                                                                        </td>
                                                                                        <td style="padding:.75pt;">
                                                                                            <p class="MsoNormal"><span style="font-family:Arial,Helvetica,sans-serif,Nunito;">&nbsp;</span><span style="font-size:12.0pt;font-family:Arial,Helvetica,sans-serif,Nunito;"><o:p></o:p></span></p>
                                                                                        </td>
                                                                                        <td style="padding:.75pt;">
                                                                                            <p class="MsoNormal"><span style="font-family:Arial,Helvetica,sans-serif,Nunito;">&nbsp;</span><span style="font-size:12.0pt;font-family:Arial,Helvetica,sans-serif,Nunito;"><o:p></o:p></span></p>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td style="padding:.75pt;"></td>
                                                                                        <td width="92%" valign="top" style="width:92%;padding:.75pt;">
                                                                                            <p class="MsoNormal" style="line-height:10.8pt;"><strong><span style="font-size:9pt;font-family:Arial,Helvetica,sans-serif,Nunito;color:#787878;">$attention</span></strong><span style="font-size:9pt;font-family:Arial,Helvetica,sans-serif,Nunito;color:#787878;"><o:p></o:p></span></p>
                                                                                            <p class="MsoNormal" style="line-height:10.8pt;"><span style="font-size:9pt;font-family:Arial,Helvetica,sans-serif,Nunito;color:#787878;">$disclaimer<o:p></o:p></span></p>
                                                                                        </td>
                                                                                        <td style="padding:.75pt;"></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td style="padding:.75pt;">
                                                                                            <p class="MsoNormal"><span style="font-family:Arial,Helvetica,sans-serif,Nunito;">&nbsp;</span><span style="font-size:12pt;font-family:Arial,Helvetica,sans-serif,Nunito;"><o:p></o:p></span></p>
                                                                                        </td>
                                                                                        <td style="padding:.75pt;"></td>
                                                                                        <td style="padding:.75pt;"></td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                            <p class="MsoNormal"><span style="font-family:Arial,Helvetica,sans-serif,Nunito;"><o:p></o:p></span></p>
									    <!-- END FOOTER -->
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <p class="MsoNormal" align="center" style="text-align:center;"><span style="font-family:Arial,Helvetica,sans-serif,Nunito;"><o:p></o:p></span></p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <p class="MsoNormal">
                    <o:p>&nbsp;</o:p>
                </p>
            </div>
        </p>
    </p>
</body>
</html>

EOT;
		return $rc; 
	}

	protected function getText($processor, $params) {
		$language    = $processor->language;
		$attention   = I18N::_(array('de' => 'Achtung!', 'en' => 'Attention!'), $language);
		$disclaimer  = I18N::_(array(
			'de' => 'Bitte antworte nicht direkt auf diese Nachricht. Diese Nachricht wurde automatisch erzeugt und dient nur zu Deiner Information.',
			'en' => 'Please do not reply to this e-mail. This message was generated automatically and was sent for your information only.',
		), $language);
		return "_________________________________________\n".
		       strtoupper($attention).' '.$disclaimer;
	}

}
