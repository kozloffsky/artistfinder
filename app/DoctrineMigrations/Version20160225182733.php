<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160225182733 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql("
            INSERT INTO `Template` (`type_id`, `template`, `is_active`) VALUES (3,
                '<!DOCTYPE html>
                <html lang=\"en\">
                <head>
                    <meta charset=\"UTF-8\">
                    <title>Title</title>
                </head>
                <body>
                <DIV id=\"page_1\">
                    <DIV id=\"dimg1\">
                    </DIV>


                    <DIV class=\"dclr\"></DIV>
                    <TABLE cellpadding=0 cellspacing=0 class=\"t0\">
                        <TR>
                            <TD class=\"tr0 td0\"><P class=\"p0 ft0\">[COMPANY_NAME]</P></TD>
                            <TD class=\"tr0 td1\"><P class=\"p1 ft1\">&nbsp;</P></TD>
                            <TD class=\"tr0 td2\"><P class=\"p1 ft1\">&nbsp;</P></TD>
                            <TD colspan=2 class=\"tr0 td3\"><P class=\"p2 ft2\">INVOICE</P></TD>
                        </TR>
                        <TR>
                            <TD class=\"tr1 td0\"><P class=\"p1 ft1\">&nbsp;</P></TD>
                            <TD class=\"tr1 td1\"><P class=\"p1 ft1\">&nbsp;</P></TD>
                            <TD class=\"tr1 td2\"><P class=\"p1 ft1\">&nbsp;</P></TD>
                            <TD class=\"tr1 td4\"><P class=\"p3 ft3\">DATE</P></TD>
                            <TD class=\"tr1 td5\"><P class=\"p1 ft3\">[TODAY_DATE]</P></TD>
                        </TR>
                        <TR>
                            <TD class=\"tr2 td0\"><P class=\"p4 ft3\">[STREET_ADDRESS]</P></TD>
                            <TD class=\"tr2 td1\"><P class=\"p1 ft1\">&nbsp;</P></TD>
                            <TD class=\"tr2 td2\"><P class=\"p1 ft1\">&nbsp;</P></TD>
                            <TD class=\"tr2 td4\"><P class=\"p3 ft3\">INVOICE #</P></TD>
                            <TD class=\"tr2 td5\"><P class=\"p1 ft3\">[INVOICE_ID]</P></TD>
                        </TR>
                        <TR>
                            <TD class=\"tr1 td0\"><P class=\"p4 ft3\">[CITY] [ZIPCODE]</P></TD>
                            <TD class=\"tr1 td1\"><P class=\"p1 ft1\">&nbsp;</P></TD>
                            <TD class=\"tr1 td2\"><P class=\"p1 ft1\">&nbsp;</P></TD>
                            <TD class=\"tr1 td4\"><P class=\"p3 ft3\">ACTED ID</P></TD>
                            <TD class=\"tr1 td5\"><P class=\"p1 ft3\">[ACTED_ID]</P></TD>
                        </TR>
                        <TR>
                            <TD class=\"tr2 td0\"><P class=\"p4 ft3\">Phone: [PHONE_NUM]</P></TD>
                            <TD class=\"tr2 td1\"><P class=\"p1 ft1\">&nbsp;</P></TD>
                            <TD class=\"tr2 td2\"><P class=\"p1 ft1\">&nbsp;</P></TD>
                            <TD class=\"tr2 td4\"><P class=\"p3 ft3\">DUE_DATE</P></TD>
                            <TD class=\"tr2 td5\"><P class=\"p1 ft3\">[DUE_DATE]</P></TD>
                        </TR>
                        <TR>
                            <TD class=\"tr1 td0\"><P class=\"p4 ft3\">Fax: [FAX_NUM]</P></TD>
                            <TD class=\"tr1 td1\"><P class=\"p1 ft1\">&nbsp;</P></TD>
                            <TD class=\"tr1 td2\"><P class=\"p1 ft1\">&nbsp;</P></TD>
                            <TD class=\"tr1 td4\"><P class=\"p1 ft1\">&nbsp;</P></TD>
                            <TD class=\"tr1 td5\"><P class=\"p1 ft1\">&nbsp;</P></TD>
                        </TR>
                        <TR>
                            <TD class=\"tr1 td0\"><P class=\"p4 ft3\">Email: [EMAIL_ADDRESS]</P></TD>
                            <TD class=\"tr1 td1\"><P class=\"p1 ft1\">&nbsp;</P></TD>
                            <TD class=\"tr1 td2\"><P class=\"p1 ft1\">&nbsp;</P></TD>
                            <TD class=\"tr1 td4\"><P class=\"p1 ft1\">&nbsp;</P></TD>
                            <TD class=\"tr1 td5\"><P class=\"p1 ft1\">&nbsp;</P></TD>
                        </TR>
                        <TR>
                            <TD class=\"tr3 td0\"><P class=\"p1 ft1\">&nbsp;</P></TD>
                            <TD class=\"tr3 td1\"><P class=\"p1 ft1\">&nbsp;</P></TD>
                            <TD class=\"tr3 td2\"><P class=\"p1 ft1\">&nbsp;</P></TD>
                            <TD class=\"tr3 td4\"><P class=\"p1 ft1\">&nbsp;</P></TD>
                            <TD class=\"tr3 td5\"><P class=\"p1 ft1\">&nbsp;</P></TD>
                        </TR>
                        <TR>
                            <TD class=\"tr4 td6\"><P class=\"p4 ft4\">BILL_TO</P></TD>
                            <TD class=\"tr4 td7\"><P class=\"p1 ft1\">&nbsp;</P></TD>
                            <TD class=\"tr4 td8\"><P class=\"p1 ft1\">&nbsp;</P></TD>
                            <TD class=\"tr4 td9\"><P class=\"p1 ft1\">&nbsp;</P></TD>
                            <TD class=\"tr4 td10\"><P class=\"p1 ft1\">&nbsp;</P></TD>
                        </TR>
                        <TR>
                            <TD class=\"tr4 td0\"><P class=\"p4 ft3\">[NAME]</P></TD>
                            <TD class=\"tr4 td1\"><P class=\"p1 ft1\">&nbsp;</P></TD>
                            <TD class=\"tr4 td2\"><P class=\"p1 ft1\">&nbsp;</P></TD>
                            <TD class=\"tr4 td4\"><P class=\"p1 ft1\">&nbsp;</P></TD>
                            <TD class=\"tr4 td5\"><P class=\"p1 ft1\">&nbsp;</P></TD>
                        </TR>
                        <TR>
                            <TD class=\"tr1 td0\"><P class=\"p4 ft3\">[COMPANY_NAME2]</P></TD>
                            <TD class=\"tr1 td1\"><P class=\"p1 ft1\">&nbsp;</P></TD>
                            <TD class=\"tr1 td2\"><P class=\"p1 ft1\">&nbsp;</P></TD>
                            <TD class=\"tr1 td4\"><P class=\"p1 ft1\">&nbsp;</P></TD>
                            <TD class=\"tr1 td5\"><P class=\"p1 ft1\">&nbsp;</P></TD>
                        </TR>
                        <TR>
                            <TD class=\"tr1 td0\"><P class=\"p4 ft3\">[STREET_ADDRESS2]</P></TD>
                            <TD class=\"tr1 td1\"><P class=\"p1 ft1\">&nbsp;</P></TD>
                            <TD class=\"tr1 td2\"><P class=\"p1 ft1\">&nbsp;</P></TD>
                            <TD class=\"tr1 td4\"><P class=\"p1 ft1\">&nbsp;</P></TD>
                            <TD class=\"tr1 td5\"><P class=\"p1 ft1\">&nbsp;</P></TD>
                        </TR>
                        <TR>
                            <TD class=\"tr2 td0\"><P class=\"p4 ft3\">[CITY2] [ZIPCODE2]</P></TD>
                            <TD class=\"tr2 td1\"><P class=\"p1 ft1\">&nbsp;</P></TD>
                            <TD class=\"tr2 td2\"><P class=\"p1 ft1\">&nbsp;</P></TD>
                            <TD class=\"tr2 td4\"><P class=\"p1 ft1\">&nbsp;</P></TD>
                            <TD class=\"tr2 td5\"><P class=\"p1 ft1\">&nbsp;</P></TD>
                        </TR>
                        <TR>
                            <TD class=\"tr1 td0\"><P class=\"p4 ft3\">[PHONE]</P></TD>
                            <TD class=\"tr1 td1\"><P class=\"p1 ft1\">&nbsp;</P></TD>
                            <TD class=\"tr1 td2\"><P class=\"p1 ft1\">&nbsp;</P></TD>
                            <TD class=\"tr1 td4\"><P class=\"p1 ft1\">&nbsp;</P></TD>
                            <TD class=\"tr1 td5\"><P class=\"p1 ft1\">&nbsp;</P></TD>
                        </TR>
                        <TR>
                            <TD class=\"tr5 td11\"><P class=\"p1 ft1\">&nbsp;</P></TD>
                            <TD class=\"tr5 td12\"><P class=\"p1 ft1\">&nbsp;</P></TD>
                            <TD class=\"tr5 td13\"><P class=\"p1 ft1\">&nbsp;</P></TD>
                            <TD class=\"tr5 td14\"><P class=\"p1 ft1\">&nbsp;</P></TD>
                            <TD class=\"tr5 td15\"><P class=\"p1 ft1\">&nbsp;</P></TD>
                        </TR>
                        <TR>
                            <TD class=\"tr4 td16\"><P class=\"p4 ft4\">DESCRIPTION</P></TD>
                            <TD class=\"tr4 td17\"><P class=\"p5 ft4\">UNIT PRICE</P></TD>
                            <TD class=\"tr4 td18\"><P class=\"p5 ft4\">QTY</P></TD>
                            <TD class=\"tr4 td19\"><P class=\"p6 ft5\">TAXED</P></TD>
                            <TD class=\"tr4 td20\"><P class=\"p6 ft5\">AMOUNT</P></TD>
                        </TR>
                        <TR>
                            <TD class=\"tr6 td21\"><P class=\"p4 ft3\">[DESCRIPTION_SERVICE1]</P></TD>
                            <TD class=\"tr6 td22\"><P class=\"p3 ft3\">[SERVICE1_UNITPRICE]</P></TD>
                            <TD class=\"tr6 td23\"><P class=\"p3 ft3\">[SERVICE1_QTY]</P></TD>
                            <TD class=\"tr6 td24\"><P class=\"p6 ft6\">[IS_SERVICE1_TAXED]</P></TD>
                            <TD class=\"tr6 td25\"><P class=\"p6 ft6\">[SERVICE1_AMOUNT]</P></TD>
                        </TR>
                        <TR>
                            <TD class=\"tr2 td21\"><P class=\"p4 ft3\">[DESCRIPTION_SERVICE2]</P></TD>
                            <TD class=\"tr2 td22\"><P class=\"p3 ft3\">[SERVICE2_UNITPRICE]</P></TD>
                            <TD class=\"tr2 td23\"><P class=\"p3 ft3\">[SERVICE2_QTY]</P></TD>
                            <TD class=\"tr2 td24\"><P class=\"p6 ft6\">[IS_SERVICE2_TAXED]</P></TD>
                            <TD class=\"tr2 td25\"><P class=\"p6 ft6\">[SERVICE2_AMOUNT]</P></TD>
                        </TR>
                        <TR>
                            <TD class=\"tr1 td21\"><P class=\"p4 ft3\"></P></TD>
                            <TD class=\"tr1 td22\"><P class=\"p3 ft3\"></P></TD>
                            <TD class=\"tr1 td23\"><P class=\"p3 ft3\"></P></TD>
                            <TD class=\"tr1 td24\"><P class=\"p6 ft6\"></P></TD>
                            <TD class=\"tr1 td25\"><P class=\"p7 ft6\"></P></TD>
                        </TR>
                        <TR>
                            <TD class=\"tr7 td26\"><P class=\"p1 ft1\">&nbsp;</P></TD>
                            <TD class=\"tr7 td27\"><P class=\"p1 ft1\">&nbsp;</P></TD>
                            <TD class=\"tr7 td28\"><P class=\"p1 ft1\">&nbsp;</P></TD>
                            <TD class=\"tr7 td29\"><P class=\"p1 ft1\">&nbsp;</P></TD>
                            <TD class=\"tr7 td30\"><P class=\"p1 ft1\">&nbsp;</P></TD>
                        </TR>
                        <TR>
                            <TD class=\"tr1 td11\"><P class=\"p1 ft1\">&nbsp;</P></TD>
                            <TD class=\"tr2 td1\"><P class=\"p1 ft1\">&nbsp;</P></TD>
                            <TD class=\"tr2 td2\"><P class=\"p1 ft1\">&nbsp;</P></TD>
                            <TD class=\"tr2 td4\"><P class=\"p7 ft7\">Subtotal</P></TD>
                            <TD class=\"tr2 td5\"><P class=\"p7 ft8\">[SUBTOTAL_AMOUNT]</P></TD>
                        </TR>
                        <TR>
                            <TD class=\"tr6 td16\"><P class=\"p4 ft4\">OTHER COMMENTS</P></TD>
                            <TD class=\"tr4 td1\"><P class=\"p1 ft1\">&nbsp;</P></TD>
                            <TD class=\"tr4 td2\"><P class=\"p1 ft1\">&nbsp;</P></TD>
                            <TD class=\"tr4 td4\"><P class=\"p7 ft6\">Taxable</P></TD>
                            <TD class=\"tr4 td5\"><P class=\"p7 ft6\">[TAXABLE_AMOUNT]</P></TD>
                        </TR>
                        <TR>
                            <TD class=\"tr4 td21\"><P class=\"p4 ft3\">1. Total payment due in 30 days</P></TD>
                            <TD class=\"tr4 td1\"><P class=\"p1 ft1\">&nbsp;</P></TD>
                            <TD class=\"tr4 td2\"><P class=\"p1 ft1\">&nbsp;</P></TD>
                            <TD class=\"tr4 td4\"><P class=\"p7 ft6\">Tax rate</P></TD>
                            <TD class=\"tr4 td5\"><P class=\"p7 ft6\">[TAX_RATE]</P></TD>
                        </TR>
                        <TR>
                            <TD class=\"tr1 td21\"><P class=\"p4 ft3\">2. Please include the invoice number on your check</P></TD>
                            <TD class=\"tr1 td1\"><P class=\"p1 ft1\">&nbsp;</P></TD>
                            <TD class=\"tr1 td2\"><P class=\"p1 ft1\">&nbsp;</P></TD>
                            <TD class=\"tr1 td4\"><P class=\"p7 ft6\">Tax due</P></TD>
                            <TD class=\"tr1 td5\"><P class=\"p7 ft6\">[TAX_AMOUNT]</P></TD>
                        </TR>
                        <TR>
                            <TD class=\"tr1 td21\"><P class=\"p1 ft1\">&nbsp;</P></TD>
                            <TD class=\"tr1 td1\"><P class=\"p1 ft1\">&nbsp;</P></TD>
                            <TD class=\"tr1 td2\"><P class=\"p1 ft1\">&nbsp;</P></TD>
                            <TD class=\"tr1 td4\"><P class=\"p7 ft6\">Other</P></TD>
                            <TD class=\"tr1 td5\"><P class=\"p7 ft6\">[OTHER_AMOUNT]</P></TD>
                        </TR>
                        <TR>
                            <TD class=\"tr8 td26\"><P class=\"p1 ft9\">&nbsp;</P></TD>
                            <TD class=\"tr9 td1\"><P class=\"p1 ft10\">&nbsp;</P></TD>
                            <TD class=\"tr9 td2\"><P class=\"p1 ft10\">&nbsp;</P></TD>
                            <TD class=\"tr8 td14\"><P class=\"p1 ft9\">&nbsp;</P></TD>
                            <TD class=\"tr8 td15\"><P class=\"p1 ft9\">&nbsp;</P></TD>
                        </TR>
                        <TR>
                            <TD class=\"tr6 td0\"><P class=\"p1 ft1\">&nbsp;</P></TD>
                            <TD class=\"tr6 td1\"><P class=\"p1 ft1\">&nbsp;</P></TD>
                            <TD class=\"tr6 td2\"><P class=\"p1 ft1\">&nbsp;</P></TD>
                            <TD class=\"tr6 td31\"><P class=\"p6 ft11\">TOTAL</P></TD>
                            <TD class=\"tr6 td32\"><P class=\"p6 ft11\">[TOTAL_AMOUNT]</P></TD>
                        </TR>
                        <TR>
                            <TD class=\"tr8 td0\"><P class=\"p1 ft9\">&nbsp;</P></TD>
                            <TD class=\"tr8 td1\"><P class=\"p1 ft9\">&nbsp;</P></TD>
                            <TD class=\"tr8 td2\"><P class=\"p1 ft9\">&nbsp;</P></TD>
                            <TD class=\"tr8 td31\"><P class=\"p1 ft9\">&nbsp;</P></TD>
                            <TD class=\"tr8 td32\"><P class=\"p1 ft9\">&nbsp;</P></TD>
                        </TR>
                    </TABLE>
                    <P class=\"p8 ft12\">Make all checks payable to</P>
                    <P class=\"p9 ft13\">[ACTED_COMPANY_NAME]</P>
                </DIV>
                </body>
                </html>',
             1);
        ");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql("
          DELETE FROM `Template` WHERE  `type_id`=3;
        ");
    }
}
