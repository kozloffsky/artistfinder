<?php
/**
 * Created by PhpStorm.
 * User: dexm1
 * Date: 25.03.16
 * Time: 11:08
 */

namespace Acted\LegalDocsBundle\DataFixtures\ORM;


use Acted\LegalDocsBundle\Entity\Template;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

class LoadTemplateData extends AbstractFixture
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        ini_set("memory_limit","1024M");

        $template1 = new Template();
        $template1->setTypeId(Template::TYPE_PERFORMANCE_CONTRACT);
        $template1->setTemplate('<!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <title>Title</title>
                </head>
                <body>
                <p>[ARTIST_ADDRESS]</p>
                <p>PERFORMANCE CONTRACT</p>
                <p>Date: [TODAY_DATE]</p>
                <p>An agreement between:</p>
                <p>[ARTIST_DETAILS]: (Hereinafter called THE ARTIST)</p>
                <p>And</p>
                <p>[CLIENT_DETAILS]: (Hereinafter called THE CLIENT)</p>
                <p>Both parties have agreed the following conditions:</p>
                <p>Subject to Terms & Condition set out below:</p>
                <p>1 – The Client agrees to engage the Artist on [EVENT_DATE] at [EVENT_LOCATION] for [PERFORMANCE_DESCRIPTION]</p>
                <p>2 – The Client agrees to provide:</p>
                <p><span>A.</span><span>Entertainment Government Permissions.</span></p>
                <p><span>B.</span><span>Payment of </span>[EVENT_AMOUNT] [CURRENCY]: deposit of
                    [DEPOSIT_AMOUNT] [CURRENCY] ([DEPOSIT_PERCENT]%) through ACTED and balance payment of [BALANCE_AMOUNT] [CURRENCY]
                    ([BALANCE_PERCENT]%) in [BALANCE_MODE] at [BALANCE_WHEN].</p>
                <p><span>C.</span><span>[TRANSPORTATION] & [ACCOMODATION]</span></p>
                <p><span>D.</span><span>Refreshment and meals for the Artist throughout the day.</span></p>
                <p><span>E.</span><span>A safe performance environment for the Artists.</span></p>
                <p><span>F.</span><span>[SPECIAL_TERMS]</span></p>
                <p>3 – The Artist agrees to the following:</p>
                <p><span>A.</span><span>The Artist will perform: [PERFORMANCE_DESCRIPTION]</span></p>
                <p>
                    <span>B.</span><span>The Artist will perform one rehearsal at a convenient time for both the Client and the Artist.</span>
                </p>
                <p><span>C.</span><span>The Artist will attend a brief from the Client when necessary.</span></p>
                <p><span>D.</span><span>The Artist agree to wear decent and appropriate costumes during every performance.</span></p>
                <p>5 – If the Client cancels the booking 7 days prior to the start of the Event ([LAST_CALL_DATE]) and
                    after the signature of this contract, the full payment is due.</p>
                <p>Executed in good faith under the sole responsibility of the contracting parties (the Client, the
                    Artist) to carry out this agreement as it is written.</p>
                <p><span>IN WITNESS WHERE OF </span>The parties have executed this <span>AGREEMENT</span>.
                </p>
                <table cellpadding="0" cellspacing="0">
                    <tr>
                        <td><p>[ARTIST_NAME]</p></td>
                        <td><p>&nbsp;</p></td>
                        <td><p>[CLIENT_NAME]</p></td>
                    </tr>
                </table>
                </body>
                </html>');
        $template1->setIsActive(true);

        $template2 = new Template();
        $template2->setTypeId(Template::TYPE_INVOICE);
        $template2->setTemplate('<!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <title>Title</title>
                </head>
                <body>
                <DIV id="page_1">
                    <DIV id="dimg1">
                    </DIV>


                    <DIV class="dclr"></DIV>
                    <TABLE cellpadding=0 cellspacing=0 class="t0">
                        <TR>
                            <TD class="tr0 td0"><P class="p0 ft0">[COMPANY_NAME]</P></TD>
                            <TD class="tr0 td1"><P class="p1 ft1">&nbsp;</P></TD>
                            <TD class="tr0 td2"><P class="p1 ft1">&nbsp;</P></TD>
                            <TD colspan=2 class="tr0 td3"><P class="p2 ft2">INVOICE</P></TD>
                        </TR>
                        <TR>
                            <TD class="tr1 td0"><P class="p1 ft1">&nbsp;</P></TD>
                            <TD class="tr1 td1"><P class="p1 ft1">&nbsp;</P></TD>
                            <TD class="tr1 td2"><P class="p1 ft1">&nbsp;</P></TD>
                            <TD class="tr1 td4"><P class="p3 ft3">DATE</P></TD>
                            <TD class="tr1 td5"><P class="p1 ft3">[TODAY_DATE]</P></TD>
                        </TR>
                        <TR>
                            <TD class="tr2 td0"><P class="p4 ft3">[STREET_ADDRESS]</P></TD>
                            <TD class="tr2 td1"><P class="p1 ft1">&nbsp;</P></TD>
                            <TD class="tr2 td2"><P class="p1 ft1">&nbsp;</P></TD>
                            <TD class="tr2 td4"><P class="p3 ft3">INVOICE #</P></TD>
                            <TD class="tr2 td5"><P class="p1 ft3">[INVOICE_ID]</P></TD>
                        </TR>
                        <TR>
                            <TD class="tr1 td0"><P class="p4 ft3">[CITY] [ZIPCODE]</P></TD>
                            <TD class="tr1 td1"><P class="p1 ft1">&nbsp;</P></TD>
                            <TD class="tr1 td2"><P class="p1 ft1">&nbsp;</P></TD>
                            <TD class="tr1 td4"><P class="p3 ft3">ACTED ID</P></TD>
                            <TD class="tr1 td5"><P class="p1 ft3">[ACTED_ID]</P></TD>
                        </TR>
                        <TR>
                            <TD class="tr2 td0"><P class="p4 ft3">Phone: [PHONE_NUM]</P></TD>
                            <TD class="tr2 td1"><P class="p1 ft1">&nbsp;</P></TD>
                            <TD class="tr2 td2"><P class="p1 ft1">&nbsp;</P></TD>
                            <TD class="tr2 td4"><P class="p3 ft3">DUE_DATE</P></TD>
                            <TD class="tr2 td5"><P class="p1 ft3">[DUE_DATE]</P></TD>
                        </TR>
                        <TR>
                            <TD class="tr1 td0"><P class="p4 ft3">Fax: [FAX_NUM]</P></TD>
                            <TD class="tr1 td1"><P class="p1 ft1">&nbsp;</P></TD>
                            <TD class="tr1 td2"><P class="p1 ft1">&nbsp;</P></TD>
                            <TD class="tr1 td4"><P class="p1 ft1">&nbsp;</P></TD>
                            <TD class="tr1 td5"><P class="p1 ft1">&nbsp;</P></TD>
                        </TR>
                        <TR>
                            <TD class="tr1 td0"><P class="p4 ft3">Email: [EMAIL_ADDRESS]</P></TD>
                            <TD class="tr1 td1"><P class="p1 ft1">&nbsp;</P></TD>
                            <TD class="tr1 td2"><P class="p1 ft1">&nbsp;</P></TD>
                            <TD class="tr1 td4"><P class="p1 ft1">&nbsp;</P></TD>
                            <TD class="tr1 td5"><P class="p1 ft1">&nbsp;</P></TD>
                        </TR>
                        <TR>
                            <TD class="tr3 td0"><P class="p1 ft1">&nbsp;</P></TD>
                            <TD class="tr3 td1"><P class="p1 ft1">&nbsp;</P></TD>
                            <TD class="tr3 td2"><P class="p1 ft1">&nbsp;</P></TD>
                            <TD class="tr3 td4"><P class="p1 ft1">&nbsp;</P></TD>
                            <TD class="tr3 td5"><P class="p1 ft1">&nbsp;</P></TD>
                        </TR>
                        <TR>
                            <TD class="tr4 td6"><P class="p4 ft4">BILL_TO</P></TD>
                            <TD class="tr4 td7"><P class="p1 ft1">&nbsp;</P></TD>
                            <TD class="tr4 td8"><P class="p1 ft1">&nbsp;</P></TD>
                            <TD class="tr4 td9"><P class="p1 ft1">&nbsp;</P></TD>
                            <TD class="tr4 td10"><P class="p1 ft1">&nbsp;</P></TD>
                        </TR>
                        <TR>
                            <TD class="tr4 td0"><P class="p4 ft3">[NAME]</P></TD>
                            <TD class="tr4 td1"><P class="p1 ft1">&nbsp;</P></TD>
                            <TD class="tr4 td2"><P class="p1 ft1">&nbsp;</P></TD>
                            <TD class="tr4 td4"><P class="p1 ft1">&nbsp;</P></TD>
                            <TD class="tr4 td5"><P class="p1 ft1">&nbsp;</P></TD>
                        </TR>
                        <TR>
                            <TD class="tr1 td0"><P class="p4 ft3">[COMPANY_NAME2]</P></TD>
                            <TD class="tr1 td1"><P class="p1 ft1">&nbsp;</P></TD>
                            <TD class="tr1 td2"><P class="p1 ft1">&nbsp;</P></TD>
                            <TD class="tr1 td4"><P class="p1 ft1">&nbsp;</P></TD>
                            <TD class="tr1 td5"><P class="p1 ft1">&nbsp;</P></TD>
                        </TR>
                        <TR>
                            <TD class="tr1 td0"><P class="p4 ft3">[STREET_ADDRESS2]</P></TD>
                            <TD class="tr1 td1"><P class="p1 ft1">&nbsp;</P></TD>
                            <TD class="tr1 td2"><P class="p1 ft1">&nbsp;</P></TD>
                            <TD class="tr1 td4"><P class="p1 ft1">&nbsp;</P></TD>
                            <TD class="tr1 td5"><P class="p1 ft1">&nbsp;</P></TD>
                        </TR>
                        <TR>
                            <TD class="tr2 td0"><P class="p4 ft3">[CITY2] [ZIPCODE2]</P></TD>
                            <TD class="tr2 td1"><P class="p1 ft1">&nbsp;</P></TD>
                            <TD class="tr2 td2"><P class="p1 ft1">&nbsp;</P></TD>
                            <TD class="tr2 td4"><P class="p1 ft1">&nbsp;</P></TD>
                            <TD class="tr2 td5"><P class="p1 ft1">&nbsp;</P></TD>
                        </TR>
                        <TR>
                            <TD class="tr1 td0"><P class="p4 ft3">[PHONE]</P></TD>
                            <TD class="tr1 td1"><P class="p1 ft1">&nbsp;</P></TD>
                            <TD class="tr1 td2"><P class="p1 ft1">&nbsp;</P></TD>
                            <TD class="tr1 td4"><P class="p1 ft1">&nbsp;</P></TD>
                            <TD class="tr1 td5"><P class="p1 ft1">&nbsp;</P></TD>
                        </TR>
                        <TR>
                            <TD class="tr5 td11"><P class="p1 ft1">&nbsp;</P></TD>
                            <TD class="tr5 td12"><P class="p1 ft1">&nbsp;</P></TD>
                            <TD class="tr5 td13"><P class="p1 ft1">&nbsp;</P></TD>
                            <TD class="tr5 td14"><P class="p1 ft1">&nbsp;</P></TD>
                            <TD class="tr5 td15"><P class="p1 ft1">&nbsp;</P></TD>
                        </TR>
                        <TR>
                            <TD class="tr4 td16"><P class="p4 ft4">DESCRIPTION</P></TD>
                            <TD class="tr4 td17"><P class="p5 ft4">UNIT PRICE</P></TD>
                            <TD class="tr4 td18"><P class="p5 ft4">QTY</P></TD>
                            <TD class="tr4 td19"><P class="p6 ft5">TAXED</P></TD>
                            <TD class="tr4 td20"><P class="p6 ft5">AMOUNT</P></TD>
                        </TR>
                        <TR>
                            <TD class="tr6 td21"><P class="p4 ft3">[DESCRIPTION_SERVICE1]</P></TD>
                            <TD class="tr6 td22"><P class="p3 ft3">[SERVICE1_UNITPRICE]</P></TD>
                            <TD class="tr6 td23"><P class="p3 ft3">[SERVICE1_QTY]</P></TD>
                            <TD class="tr6 td24"><P class="p6 ft6">[IS_SERVICE1_TAXED]</P></TD>
                            <TD class="tr6 td25"><P class="p6 ft6">[SERVICE1_AMOUNT]</P></TD>
                        </TR>
                        <TR>
                            <TD class="tr2 td21"><P class="p4 ft3">[DESCRIPTION_SERVICE2]</P></TD>
                            <TD class="tr2 td22"><P class="p3 ft3">[SERVICE2_UNITPRICE]</P></TD>
                            <TD class="tr2 td23"><P class="p3 ft3">[SERVICE2_QTY]</P></TD>
                            <TD class="tr2 td24"><P class="p6 ft6">[IS_SERVICE2_TAXED]</P></TD>
                            <TD class="tr2 td25"><P class="p6 ft6">[SERVICE2_AMOUNT]</P></TD>
                        </TR>
                        <TR>
                            <TD class="tr1 td21"><P class="p4 ft3"></P></TD>
                            <TD class="tr1 td22"><P class="p3 ft3"></P></TD>
                            <TD class="tr1 td23"><P class="p3 ft3"></P></TD>
                            <TD class="tr1 td24"><P class="p6 ft6"></P></TD>
                            <TD class="tr1 td25"><P class="p7 ft6"></P></TD>
                        </TR>
                        <TR>
                            <TD class="tr7 td26"><P class="p1 ft1">&nbsp;</P></TD>
                            <TD class="tr7 td27"><P class="p1 ft1">&nbsp;</P></TD>
                            <TD class="tr7 td28"><P class="p1 ft1">&nbsp;</P></TD>
                            <TD class="tr7 td29"><P class="p1 ft1">&nbsp;</P></TD>
                            <TD class="tr7 td30"><P class="p1 ft1">&nbsp;</P></TD>
                        </TR>
                        <TR>
                            <TD class="tr1 td11"><P class="p1 ft1">&nbsp;</P></TD>
                            <TD class="tr2 td1"><P class="p1 ft1">&nbsp;</P></TD>
                            <TD class="tr2 td2"><P class="p1 ft1">&nbsp;</P></TD>
                            <TD class="tr2 td4"><P class="p7 ft7">Subtotal</P></TD>
                            <TD class="tr2 td5"><P class="p7 ft8">[SUBTOTAL_AMOUNT]</P></TD>
                        </TR>
                        <TR>
                            <TD class="tr6 td16"><P class="p4 ft4">OTHER COMMENTS</P></TD>
                            <TD class="tr4 td1"><P class="p1 ft1">&nbsp;</P></TD>
                            <TD class="tr4 td2"><P class="p1 ft1">&nbsp;</P></TD>
                            <TD class="tr4 td4"><P class="p7 ft6">Taxable</P></TD>
                            <TD class="tr4 td5"><P class="p7 ft6">[TAXABLE_AMOUNT]</P></TD>
                        </TR>
                        <TR>
                            <TD class="tr4 td21"><P class="p4 ft3">1. Total payment due in 30 days</P></TD>
                            <TD class="tr4 td1"><P class="p1 ft1">&nbsp;</P></TD>
                            <TD class="tr4 td2"><P class="p1 ft1">&nbsp;</P></TD>
                            <TD class="tr4 td4"><P class="p7 ft6">Tax rate</P></TD>
                            <TD class="tr4 td5"><P class="p7 ft6">[TAX_RATE]</P></TD>
                        </TR>
                        <TR>
                            <TD class="tr1 td21"><P class="p4 ft3">2. Please include the invoice number on your check</P></TD>
                            <TD class="tr1 td1"><P class="p1 ft1">&nbsp;</P></TD>
                            <TD class="tr1 td2"><P class="p1 ft1">&nbsp;</P></TD>
                            <TD class="tr1 td4"><P class="p7 ft6">Tax due</P></TD>
                            <TD class="tr1 td5"><P class="p7 ft6">[TAX_AMOUNT]</P></TD>
                        </TR>
                        <TR>
                            <TD class="tr1 td21"><P class="p1 ft1">&nbsp;</P></TD>
                            <TD class="tr1 td1"><P class="p1 ft1">&nbsp;</P></TD>
                            <TD class="tr1 td2"><P class="p1 ft1">&nbsp;</P></TD>
                            <TD class="tr1 td4"><P class="p7 ft6">Other</P></TD>
                            <TD class="tr1 td5"><P class="p7 ft6">[OTHER_AMOUNT]</P></TD>
                        </TR>
                        <TR>
                            <TD class="tr8 td26"><P class="p1 ft9">&nbsp;</P></TD>
                            <TD class="tr9 td1"><P class="p1 ft10">&nbsp;</P></TD>
                            <TD class="tr9 td2"><P class="p1 ft10">&nbsp;</P></TD>
                            <TD class="tr8 td14"><P class="p1 ft9">&nbsp;</P></TD>
                            <TD class="tr8 td15"><P class="p1 ft9">&nbsp;</P></TD>
                        </TR>
                        <TR>
                            <TD class="tr6 td0"><P class="p1 ft1">&nbsp;</P></TD>
                            <TD class="tr6 td1"><P class="p1 ft1">&nbsp;</P></TD>
                            <TD class="tr6 td2"><P class="p1 ft1">&nbsp;</P></TD>
                            <TD class="tr6 td31"><P class="p6 ft11">TOTAL</P></TD>
                            <TD class="tr6 td32"><P class="p6 ft11">[TOTAL_AMOUNT]</P></TD>
                        </TR>
                        <TR>
                            <TD class="tr8 td0"><P class="p1 ft9">&nbsp;</P></TD>
                            <TD class="tr8 td1"><P class="p1 ft9">&nbsp;</P></TD>
                            <TD class="tr8 td2"><P class="p1 ft9">&nbsp;</P></TD>
                            <TD class="tr8 td31"><P class="p1 ft9">&nbsp;</P></TD>
                            <TD class="tr8 td32"><P class="p1 ft9">&nbsp;</P></TD>
                        </TR>
                    </TABLE>
                    <P class="p8 ft12">Make all checks payable to</P>
                    <P class="p9 ft13">[ACTED_COMPANY_NAME]</P>
                </DIV>
                </body>
                </html>');
        $template2->setIsActive(true);

        $template3 = new Template();
        $template3->setTypeId(Template::TYPE_QUOTATION);
        $template3->setTemplate('<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
<DIV id="page_1">
    <TABLE cellpadding=0 cellspacing=0 class="t0">
        <TR>
            <TD class="tr0 td0"><P class="p0 ft0">&nbsp;</P></TD>
            <TD class="tr0 td1"><P class="p1 ft1">[ARTIST_NAME]</P></TD>
            <TD colspan=2 class="tr0 td2"><P class="p2 ft2">QUOTATION</P></TD>
            <TD class="tr0 td3"><P class="p0 ft0">&nbsp;</P></TD>
        </TR>
        <TR>
            <TD class="tr1 td4"><P class="p0 ft0">&nbsp;</P></TD>
            <TD class="tr1 td5"><P class="p0 ft0">&nbsp;</P></TD>
            <TD class="tr1 td6"><P class="p3 ft3">DATE</P></TD>
            <TD class="tr1 td7"><P class="p0 ft3">[TODAY_DATE]</P></TD>
            <TD class="tr1 td8"><P class="p0 ft0">&nbsp;</P></TD>
        </TR>
        <TR>
            <TD class="tr1 td4"><P class="p0 ft0">&nbsp;</P></TD>
            <TD class="tr1 td5"><P class="p1 ft4">[STREET_ADDRESS]</P></TD>
            <TD class="tr1 td6"><P class="p3 ft4">QUOTATION #</P></TD>
            <TD class="tr1 td7"><P class="p0 ft4">[QUOTATION_ID]</P></TD>
            <TD class="tr1 td8"><P class="p0 ft0">&nbsp;</P></TD>
        </TR>
        <TR>
            <TD class="tr2 td4"><P class="p0 ft0">&nbsp;</P></TD>
            <TD class="tr2 td5"><P class="p1 ft3">[CITY] [ZIPCODE]</P></TD>
            <TD class="tr2 td6"><P class="p3 ft3">ACTED ID</P></TD>
            <TD class="tr2 td7"><P class="p0 ft3">[ACTED_ID]</P></TD>
            <TD class="tr2 td8"><P class="p0 ft0">&nbsp;</P></TD>
        </TR>
        <TR>
            <TD class="tr1 td4"><P class="p0 ft0">&nbsp;</P></TD>
            <TD class="tr1 td5"><P class="p1 ft4">Phone: [PHONE_NUM]</P></TD>
            <TD class="tr1 td6"><P class="p3 ft4">EXPIRY DATE</P></TD>
            <TD class="tr1 td7"><P class="p0 ft4">[EXPIRY_DATE]</P></TD>
            <TD class="tr1 td8"><P class="p0 ft0">&nbsp;</P></TD>
        </TR>
        <TR>
            <TD class="tr2 td4"><P class="p0 ft0">&nbsp;</P></TD>
            <TD class="tr2 td5"><P class="p1 ft3">Fax: [FAX_NUM]</P></TD>
            <TD class="tr2 td6"><P class="p0 ft0">&nbsp;</P></TD>
            <TD class="tr2 td7"><P class="p0 ft0">&nbsp;</P></TD>
            <TD class="tr2 td8"><P class="p0 ft0">&nbsp;</P></TD>
        </TR>
        <TR>
            <TD class="tr1 td4"><P class="p0 ft0">&nbsp;</P></TD>
            <TD class="tr1 td5"><P class="p1 ft4">Email: [EMAIL_ADDRESS]</P></TD>
            <TD class="tr1 td6"><P class="p0 ft0">&nbsp;</P></TD>
            <TD class="tr1 td7"><P class="p0 ft0">&nbsp;</P></TD>
            <TD class="tr1 td8"><P class="p0 ft0">&nbsp;</P></TD>
        </TR>
        <TR>
            <TD class="tr3 td4"><P class="p0 ft0">&nbsp;</P></TD>
            <TD class="tr3 td5"><P class="p0 ft0">&nbsp;</P></TD>
            <TD class="tr3 td6"><P class="p0 ft0">&nbsp;</P></TD>
            <TD class="tr3 td7"><P class="p0 ft0">&nbsp;</P></TD>
            <TD class="tr3 td8"><P class="p0 ft0">&nbsp;</P></TD>
        </TR>
        <TR>
            <TD class="tr2 td9"><P class="p0 ft0">&nbsp;</P></TD>
            <TD class="tr4 td10"><P class="p1 ft5">BILL TO</P></TD>
            <TD class="tr4 td11"><P class="p0 ft0">&nbsp;</P></TD>
            <TD class="tr4 td12"><P class="p0 ft0">&nbsp;</P></TD>
            <TD class="tr2 td8"><P class="p0 ft0">&nbsp;</P></TD>
        </TR>
        <TR>
            <TD class="tr4 td4"><P class="p0 ft0">&nbsp;</P></TD>
            <TD class="tr4 td5"><P class="p1 ft3">[NAME]</P></TD>
            <TD class="tr4 td6"><P class="p0 ft0">&nbsp;</P></TD>
            <TD class="tr4 td7"><P class="p0 ft0">&nbsp;</P></TD>
            <TD class="tr4 td8"><P class="p0 ft0">&nbsp;</P></TD>
        </TR>
        <TR>
            <TD class="tr2 td4"><P class="p0 ft0">&nbsp;</P></TD>
            <TD class="tr2 td5"><P class="p1 ft4">[COMPANY_NAME]</P></TD>
            <TD class="tr2 td6"><P class="p0 ft0">&nbsp;</P></TD>
            <TD class="tr2 td7"><P class="p0 ft0">&nbsp;</P></TD>
            <TD class="tr2 td8"><P class="p0 ft0">&nbsp;</P></TD>
        </TR>
        <TR>
            <TD class="tr1 td4"><P class="p0 ft0">&nbsp;</P></TD>
            <TD class="tr1 td5"><P class="p1 ft3">[STREET_ADDRESS2]</P></TD>
            <TD class="tr1 td6"><P class="p0 ft0">&nbsp;</P></TD>
            <TD class="tr1 td7"><P class="p0 ft0">&nbsp;</P></TD>
            <TD class="tr1 td8"><P class="p0 ft0">&nbsp;</P></TD>
        </TR>
        <TR>
            <TD class="tr2 td4"><P class="p0 ft0">&nbsp;</P></TD>
            <TD class="tr2 td5"><P class="p1 ft4">[CITY2] [ZIPCODE2]</P></TD>
            <TD class="tr2 td6"><P class="p0 ft0">&nbsp;</P></TD>
            <TD class="tr2 td7"><P class="p0 ft0">&nbsp;</P></TD>
            <TD class="tr2 td8"><P class="p0 ft0">&nbsp;</P></TD>
        </TR>
        <TR>
            <TD class="tr1 td4"><P class="p0 ft0">&nbsp;</P></TD>
            <TD class="tr1 td5"><P class="p1 ft3">[PHONE]</P></TD>
            <TD class="tr1 td6"><P class="p0 ft0">&nbsp;</P></TD>
            <TD class="tr1 td7"><P class="p0 ft0">&nbsp;</P></TD>
            <TD class="tr1 td8"><P class="p0 ft0">&nbsp;</P></TD>
        </TR>
        <TR>
            <TD class="tr0 td4"><P class="p0 ft0">&nbsp;</P></TD>
            <TD class="tr0 td5"><P class="p1 ft3">Event details: [LOCATION] [TIMING]</P></TD>
            <TD class="tr0 td6"><P class="p0 ft0">&nbsp;</P></TD>
            <TD class="tr0 td7"><P class="p0 ft0">&nbsp;</P></TD>
            <TD class="tr0 td8"><P class="p0 ft0">&nbsp;</P></TD>
        </TR>
        <TR>
            <TD class="tr1 td4"><P class="p0 ft0">&nbsp;</P></TD>
            <TD class="tr1 td5"><P class="p1 ft4">Comment or special instructions: [SPECIAL_INSTRUCTIONS]</P></TD>
            <TD class="tr1 td6"><P class="p0 ft0">&nbsp;</P></TD>
            <TD class="tr1 td7"><P class="p0 ft0">&nbsp;</P></TD>
            <TD class="tr1 td8"><P class="p0 ft0">&nbsp;</P></TD>
        </TR>
        <TR>
            <TD class="tr5 td4"><P class="p0 ft0">&nbsp;</P></TD>
            <TD class="tr6 td13"><P class="p0 ft0">&nbsp;</P></TD>
            <TD class="tr6 td14"><P class="p0 ft0">&nbsp;</P></TD>
            <TD class="tr6 td15"><P class="p0 ft0">&nbsp;</P></TD>
            <TD class="tr5 td8"><P class="p0 ft0">&nbsp;</P></TD>
        </TR>
        <TR>
            <TD class="tr4 td16"><P class="p0 ft0">&nbsp;</P></TD>
            <TD class="tr4 td17"><P class="p1 ft6">DESCRIPTION</P></TD>
            <TD class="tr4 td18"><P class="p4 ft7">TAXED</P></TD>
            <TD class="tr4 td19"><P class="p4 ft6">AMOUNT</P></TD>
            <TD class="tr4 td8"><P class="p0 ft0">&nbsp;</P></TD>
        </TR>
        <TR>
            <TD class="tr4 td16"><P class="p0 ft0">&nbsp;</P></TD>
            <TD class="tr4 td20"><P class="p1 ft3">[DESCRIPTION_SERVICE1]</P></TD>
            <TD class="tr4 td21"><P class="p5 ft8">[IS_SERVICE1_TAXED]</P></TD>
            <TD class="tr4 td22"><P class="p4 ft8">[SERVICE1_AMOUNT]</P></TD>
            <TD class="tr4 td8"><P class="p0 ft0">&nbsp;</P></TD>
        </TR>
        <TR>
            <TD class="tr1 td16"><P class="p0 ft0">&nbsp;</P></TD>
            <TD class="tr1 td20"><P class="p1 ft4">[DESCRIPTION_SERVICE2]</P></TD>
            <TD class="tr1 td21"><P class="p5 ft9">[IS_SERVICE2_TAXED]</P></TD>
            <TD class="tr1 td22"><P class="p4 ft9">[SERVICE2_AMOUNT]</P></TD>
            <TD class="tr1 td8"><P class="p0 ft0">&nbsp;</P></TD>
        </TR>
        <TR>
            <TD class="tr2 td16"><P class="p0 ft0">&nbsp;</P></TD>
            <TD class="tr2 td20"><P class="p1 ft3"></P></TD>
            <TD class="tr2 td21"><P class="p5 ft3"></P></TD>
            <TD class="tr2 td22"><P class="p4 ft3"></P></TD>
            <TD class="tr2 td8"><P class="p0 ft0">&nbsp;</P></TD>
        </TR>
        <TR>
            <TD class="tr7 td16"><P class="p0 ft0">&nbsp;</P></TD>
            <TD class="tr3 td23"><P class="p0 ft0">&nbsp;</P></TD>
            <TD class="tr3 td24"><P class="p0 ft0">&nbsp;</P></TD>
            <TD class="tr3 td25"><P class="p0 ft0">&nbsp;</P></TD>
            <TD class="tr7 td8"><P class="p0 ft0">&nbsp;</P></TD>
        </TR>
        <TR>
            <TD class="tr4 td4"><P class="p0 ft0">&nbsp;</P></TD>
            <TD class="tr4 td5"><P class="p0 ft0">&nbsp;</P></TD>
            <TD class="tr4 td6"><P class="p6 ft9">Subtotal</P></TD>
            <TD class="tr4 td7"><P class="p5 ft9">[SUBTOTAL_AMOUNT]</P></TD>
            <TD class="tr4 td8"><P class="p0 ft0">&nbsp;</P></TD>
        </TR>
        <TR>
            <TD class="tr1 td9"><P class="p0 ft0">&nbsp;</P></TD>
            <TD class="tr2 td10"><P class="p1 ft5">OTHER COMMENTS</P></TD>
            <TD class="tr1 td6"><P class="p6 ft8">Taxable</P></TD>
            <TD class="tr1 td7"><P class="p5 ft8">[TAXABLE_AMOUNT]</P></TD>
            <TD class="tr1 td8"><P class="p0 ft0">&nbsp;</P></TD>
        </TR>
        <TR>
            <TD class="tr4 td4"><P class="p0 ft0">&nbsp;</P></TD>
            <TD class="tr4 td5"><P class="p1 ft4">[DEPOSIT_PERCENT] deposit payment [DEPOSIT_AMOUNT] due now</P></TD>
            <TD class="tr4 td6"><P class="p6 ft9">Tax rate</P></TD>
            <TD class="tr4 td7"><P class="p5 ft9">[TAX_RATE]</P></TD>
            <TD class="tr4 td8"><P class="p0 ft0">&nbsp;</P></TD>
        </TR>
        <TR>
            <TD class="tr2 td4"><P class="p0 ft0">&nbsp;</P></TD>
            <TD class="tr2 td5"><P class="p1 ft3">[BALANCE_PERCENT] balance payment [BALANCE_AMOUNT] due [BALANCE_WHEN] in [BALANCE_MODE]</P></TD>
            <TD class="tr2 td6"><P class="p6 ft8">Tax due</P></TD>
            <TD class="tr2 td7"><P class="p5 ft8">[TAX_AMOUNT]</P></TD>
            <TD class="tr2 td8"><P class="p0 ft0">&nbsp;</P></TD>
        </TR>
        <TR>
            <TD class="tr5 td4"><P class="p0 ft0">&nbsp;</P></TD>
            <TD class="tr5 td5"><P class="p1 ft4">[ADDITIONAL_COMMENTS]</P></TD>
            <TD class="tr6 td14"><P class="p6 ft9">Other</P></TD>
            <TD class="tr6 td15"><P class="p5 ft9">[OTHER_AMOUNT]</P></TD>
            <TD class="tr5 td8"><P class="p0 ft0">&nbsp;</P></TD>
        </TR>
        <TR>
            <TD class="tr2 td4"><P class="p0 ft0">&nbsp;</P></TD>
            <TD class="tr2 td5"><P class="p0 ft0">&nbsp;</P></TD>
            <TD class="tr2 td26"><P class="p5 ft10">TOTAL</P></TD>
            <TD class="tr4 td27"><P class="p4 ft10">[TOTAL_AMOUNT]</P></TD>
            <TD class="tr2 td8"><P class="p0 ft0">&nbsp;</P></TD>
        </TR>
        <TR>
            <TD class="tr2 td28"><P class="p0 ft0">&nbsp;</P></TD>
            <TD class="tr2 td13"><P class="p0 ft0">&nbsp;</P></TD>
            <TD class="tr2 td14"><P class="p0 ft0">&nbsp;</P></TD>
            <TD class="tr2 td15"><P class="p0 ft0">&nbsp;</P></TD>
            <TD class="tr2 td29"><P class="p0 ft0">&nbsp;</P></TD>
        </TR>
    </TABLE>
</DIV>
</body>
</html>');
        $template3->setIsActive(true);

        $manager->persist($template1);
        $manager->persist($template2);
        $manager->persist($template3);
        $manager->flush();
    }
}