<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160225194656 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql("
            INSERT INTO `Template` (`type_id`, `template`, `is_active`) VALUES (2,
                '<!DOCTYPE html>
<html lang=\"en\">
<head>
    <meta charset=\"UTF-8\">
    <title>Title</title>
</head>
<body>
<DIV id=\"page_1\">
    <TABLE cellpadding=0 cellspacing=0 class=\"t0\">
        <TR>
            <TD class=\"tr0 td0\"><P class=\"p0 ft0\">&nbsp;</P></TD>
            <TD class=\"tr0 td1\"><P class=\"p1 ft1\">[ARTIST_NAME]</P></TD>
            <TD colspan=2 class=\"tr0 td2\"><P class=\"p2 ft2\">QUOTATION</P></TD>
            <TD class=\"tr0 td3\"><P class=\"p0 ft0\">&nbsp;</P></TD>
        </TR>
        <TR>
            <TD class=\"tr1 td4\"><P class=\"p0 ft0\">&nbsp;</P></TD>
            <TD class=\"tr1 td5\"><P class=\"p0 ft0\">&nbsp;</P></TD>
            <TD class=\"tr1 td6\"><P class=\"p3 ft3\">DATE</P></TD>
            <TD class=\"tr1 td7\"><P class=\"p0 ft3\">[TODAY_DATE]</P></TD>
            <TD class=\"tr1 td8\"><P class=\"p0 ft0\">&nbsp;</P></TD>
        </TR>
        <TR>
            <TD class=\"tr1 td4\"><P class=\"p0 ft0\">&nbsp;</P></TD>
            <TD class=\"tr1 td5\"><P class=\"p1 ft4\">[STREET_ADDRESS]</P></TD>
            <TD class=\"tr1 td6\"><P class=\"p3 ft4\">QUOTATION #</P></TD>
            <TD class=\"tr1 td7\"><P class=\"p0 ft4\">[QUOTATION_ID]</P></TD>
            <TD class=\"tr1 td8\"><P class=\"p0 ft0\">&nbsp;</P></TD>
        </TR>
        <TR>
            <TD class=\"tr2 td4\"><P class=\"p0 ft0\">&nbsp;</P></TD>
            <TD class=\"tr2 td5\"><P class=\"p1 ft3\">[CITY] [ZIPCODE]</P></TD>
            <TD class=\"tr2 td6\"><P class=\"p3 ft3\">ACTED ID</P></TD>
            <TD class=\"tr2 td7\"><P class=\"p0 ft3\">[ACTED_ID]</P></TD>
            <TD class=\"tr2 td8\"><P class=\"p0 ft0\">&nbsp;</P></TD>
        </TR>
        <TR>
            <TD class=\"tr1 td4\"><P class=\"p0 ft0\">&nbsp;</P></TD>
            <TD class=\"tr1 td5\"><P class=\"p1 ft4\">Phone: [PHONE_NUM]</P></TD>
            <TD class=\"tr1 td6\"><P class=\"p3 ft4\">EXPIRY DATE</P></TD>
            <TD class=\"tr1 td7\"><P class=\"p0 ft4\">[EXPIRY_DATE]</P></TD>
            <TD class=\"tr1 td8\"><P class=\"p0 ft0\">&nbsp;</P></TD>
        </TR>
        <TR>
            <TD class=\"tr2 td4\"><P class=\"p0 ft0\">&nbsp;</P></TD>
            <TD class=\"tr2 td5\"><P class=\"p1 ft3\">Fax: [FAX_NUM]</P></TD>
            <TD class=\"tr2 td6\"><P class=\"p0 ft0\">&nbsp;</P></TD>
            <TD class=\"tr2 td7\"><P class=\"p0 ft0\">&nbsp;</P></TD>
            <TD class=\"tr2 td8\"><P class=\"p0 ft0\">&nbsp;</P></TD>
        </TR>
        <TR>
            <TD class=\"tr1 td4\"><P class=\"p0 ft0\">&nbsp;</P></TD>
            <TD class=\"tr1 td5\"><P class=\"p1 ft4\">Email: [EMAIL_ADDRESS]</P></TD>
            <TD class=\"tr1 td6\"><P class=\"p0 ft0\">&nbsp;</P></TD>
            <TD class=\"tr1 td7\"><P class=\"p0 ft0\">&nbsp;</P></TD>
            <TD class=\"tr1 td8\"><P class=\"p0 ft0\">&nbsp;</P></TD>
        </TR>
        <TR>
            <TD class=\"tr3 td4\"><P class=\"p0 ft0\">&nbsp;</P></TD>
            <TD class=\"tr3 td5\"><P class=\"p0 ft0\">&nbsp;</P></TD>
            <TD class=\"tr3 td6\"><P class=\"p0 ft0\">&nbsp;</P></TD>
            <TD class=\"tr3 td7\"><P class=\"p0 ft0\">&nbsp;</P></TD>
            <TD class=\"tr3 td8\"><P class=\"p0 ft0\">&nbsp;</P></TD>
        </TR>
        <TR>
            <TD class=\"tr2 td9\"><P class=\"p0 ft0\">&nbsp;</P></TD>
            <TD class=\"tr4 td10\"><P class=\"p1 ft5\">BILL TO</P></TD>
            <TD class=\"tr4 td11\"><P class=\"p0 ft0\">&nbsp;</P></TD>
            <TD class=\"tr4 td12\"><P class=\"p0 ft0\">&nbsp;</P></TD>
            <TD class=\"tr2 td8\"><P class=\"p0 ft0\">&nbsp;</P></TD>
        </TR>
        <TR>
            <TD class=\"tr4 td4\"><P class=\"p0 ft0\">&nbsp;</P></TD>
            <TD class=\"tr4 td5\"><P class=\"p1 ft3\">[NAME]</P></TD>
            <TD class=\"tr4 td6\"><P class=\"p0 ft0\">&nbsp;</P></TD>
            <TD class=\"tr4 td7\"><P class=\"p0 ft0\">&nbsp;</P></TD>
            <TD class=\"tr4 td8\"><P class=\"p0 ft0\">&nbsp;</P></TD>
        </TR>
        <TR>
            <TD class=\"tr2 td4\"><P class=\"p0 ft0\">&nbsp;</P></TD>
            <TD class=\"tr2 td5\"><P class=\"p1 ft4\">[COMPANY_NAME]</P></TD>
            <TD class=\"tr2 td6\"><P class=\"p0 ft0\">&nbsp;</P></TD>
            <TD class=\"tr2 td7\"><P class=\"p0 ft0\">&nbsp;</P></TD>
            <TD class=\"tr2 td8\"><P class=\"p0 ft0\">&nbsp;</P></TD>
        </TR>
        <TR>
            <TD class=\"tr1 td4\"><P class=\"p0 ft0\">&nbsp;</P></TD>
            <TD class=\"tr1 td5\"><P class=\"p1 ft3\">[STREET_ADDRESS2]</P></TD>
            <TD class=\"tr1 td6\"><P class=\"p0 ft0\">&nbsp;</P></TD>
            <TD class=\"tr1 td7\"><P class=\"p0 ft0\">&nbsp;</P></TD>
            <TD class=\"tr1 td8\"><P class=\"p0 ft0\">&nbsp;</P></TD>
        </TR>
        <TR>
            <TD class=\"tr2 td4\"><P class=\"p0 ft0\">&nbsp;</P></TD>
            <TD class=\"tr2 td5\"><P class=\"p1 ft4\">[CITY2] [ZIPCODE2]</P></TD>
            <TD class=\"tr2 td6\"><P class=\"p0 ft0\">&nbsp;</P></TD>
            <TD class=\"tr2 td7\"><P class=\"p0 ft0\">&nbsp;</P></TD>
            <TD class=\"tr2 td8\"><P class=\"p0 ft0\">&nbsp;</P></TD>
        </TR>
        <TR>
            <TD class=\"tr1 td4\"><P class=\"p0 ft0\">&nbsp;</P></TD>
            <TD class=\"tr1 td5\"><P class=\"p1 ft3\">[PHONE]</P></TD>
            <TD class=\"tr1 td6\"><P class=\"p0 ft0\">&nbsp;</P></TD>
            <TD class=\"tr1 td7\"><P class=\"p0 ft0\">&nbsp;</P></TD>
            <TD class=\"tr1 td8\"><P class=\"p0 ft0\">&nbsp;</P></TD>
        </TR>
        <TR>
            <TD class=\"tr0 td4\"><P class=\"p0 ft0\">&nbsp;</P></TD>
            <TD class=\"tr0 td5\"><P class=\"p1 ft3\">Event details: [LOCATION] [TIMING]</P></TD>
            <TD class=\"tr0 td6\"><P class=\"p0 ft0\">&nbsp;</P></TD>
            <TD class=\"tr0 td7\"><P class=\"p0 ft0\">&nbsp;</P></TD>
            <TD class=\"tr0 td8\"><P class=\"p0 ft0\">&nbsp;</P></TD>
        </TR>
        <TR>
            <TD class=\"tr1 td4\"><P class=\"p0 ft0\">&nbsp;</P></TD>
            <TD class=\"tr1 td5\"><P class=\"p1 ft4\">Comment or special instructions: [SPECIAL_INSTRUCTIONS]</P></TD>
            <TD class=\"tr1 td6\"><P class=\"p0 ft0\">&nbsp;</P></TD>
            <TD class=\"tr1 td7\"><P class=\"p0 ft0\">&nbsp;</P></TD>
            <TD class=\"tr1 td8\"><P class=\"p0 ft0\">&nbsp;</P></TD>
        </TR>
        <TR>
            <TD class=\"tr5 td4\"><P class=\"p0 ft0\">&nbsp;</P></TD>
            <TD class=\"tr6 td13\"><P class=\"p0 ft0\">&nbsp;</P></TD>
            <TD class=\"tr6 td14\"><P class=\"p0 ft0\">&nbsp;</P></TD>
            <TD class=\"tr6 td15\"><P class=\"p0 ft0\">&nbsp;</P></TD>
            <TD class=\"tr5 td8\"><P class=\"p0 ft0\">&nbsp;</P></TD>
        </TR>
        <TR>
            <TD class=\"tr4 td16\"><P class=\"p0 ft0\">&nbsp;</P></TD>
            <TD class=\"tr4 td17\"><P class=\"p1 ft6\">DESCRIPTION</P></TD>
            <TD class=\"tr4 td18\"><P class=\"p4 ft7\">TAXED</P></TD>
            <TD class=\"tr4 td19\"><P class=\"p4 ft6\">AMOUNT</P></TD>
            <TD class=\"tr4 td8\"><P class=\"p0 ft0\">&nbsp;</P></TD>
        </TR>
        <TR>
            <TD class=\"tr4 td16\"><P class=\"p0 ft0\">&nbsp;</P></TD>
            <TD class=\"tr4 td20\"><P class=\"p1 ft3\">[DESCRIPTION_SERVICE1]</P></TD>
            <TD class=\"tr4 td21\"><P class=\"p5 ft8\">[IS_SERVICE1_TAXED]</P></TD>
            <TD class=\"tr4 td22\"><P class=\"p4 ft8\">[SERVICE1_AMOUNT]</P></TD>
            <TD class=\"tr4 td8\"><P class=\"p0 ft0\">&nbsp;</P></TD>
        </TR>
        <TR>
            <TD class=\"tr1 td16\"><P class=\"p0 ft0\">&nbsp;</P></TD>
            <TD class=\"tr1 td20\"><P class=\"p1 ft4\">[DESCRIPTION_SERVICE2]</P></TD>
            <TD class=\"tr1 td21\"><P class=\"p5 ft9\">[IS_SERVICE2_TAXED]</P></TD>
            <TD class=\"tr1 td22\"><P class=\"p4 ft9\">[SERVICE2_AMOUNT]</P></TD>
            <TD class=\"tr1 td8\"><P class=\"p0 ft0\">&nbsp;</P></TD>
        </TR>
        <TR>
            <TD class=\"tr2 td16\"><P class=\"p0 ft0\">&nbsp;</P></TD>
            <TD class=\"tr2 td20\"><P class=\"p1 ft3\"></P></TD>
            <TD class=\"tr2 td21\"><P class=\"p5 ft3\"></P></TD>
            <TD class=\"tr2 td22\"><P class=\"p4 ft3\"></P></TD>
            <TD class=\"tr2 td8\"><P class=\"p0 ft0\">&nbsp;</P></TD>
        </TR>
        <TR>
            <TD class=\"tr7 td16\"><P class=\"p0 ft0\">&nbsp;</P></TD>
            <TD class=\"tr3 td23\"><P class=\"p0 ft0\">&nbsp;</P></TD>
            <TD class=\"tr3 td24\"><P class=\"p0 ft0\">&nbsp;</P></TD>
            <TD class=\"tr3 td25\"><P class=\"p0 ft0\">&nbsp;</P></TD>
            <TD class=\"tr7 td8\"><P class=\"p0 ft0\">&nbsp;</P></TD>
        </TR>
        <TR>
            <TD class=\"tr4 td4\"><P class=\"p0 ft0\">&nbsp;</P></TD>
            <TD class=\"tr4 td5\"><P class=\"p0 ft0\">&nbsp;</P></TD>
            <TD class=\"tr4 td6\"><P class=\"p6 ft9\">Subtotal</P></TD>
            <TD class=\"tr4 td7\"><P class=\"p5 ft9\">[SUBTOTAL_AMOUNT]</P></TD>
            <TD class=\"tr4 td8\"><P class=\"p0 ft0\">&nbsp;</P></TD>
        </TR>
        <TR>
            <TD class=\"tr1 td9\"><P class=\"p0 ft0\">&nbsp;</P></TD>
            <TD class=\"tr2 td10\"><P class=\"p1 ft5\">OTHER COMMENTS</P></TD>
            <TD class=\"tr1 td6\"><P class=\"p6 ft8\">Taxable</P></TD>
            <TD class=\"tr1 td7\"><P class=\"p5 ft8\">[TAXABLE_AMOUNT]</P></TD>
            <TD class=\"tr1 td8\"><P class=\"p0 ft0\">&nbsp;</P></TD>
        </TR>
        <TR>
            <TD class=\"tr4 td4\"><P class=\"p0 ft0\">&nbsp;</P></TD>
            <TD class=\"tr4 td5\"><P class=\"p1 ft4\">[DEPOSIT_PERCENT] deposit payment [DEPOSIT_AMOUNT] due now</P></TD>
            <TD class=\"tr4 td6\"><P class=\"p6 ft9\">Tax rate</P></TD>
            <TD class=\"tr4 td7\"><P class=\"p5 ft9\">[TAX_RATE]</P></TD>
            <TD class=\"tr4 td8\"><P class=\"p0 ft0\">&nbsp;</P></TD>
        </TR>
        <TR>
            <TD class=\"tr2 td4\"><P class=\"p0 ft0\">&nbsp;</P></TD>
            <TD class=\"tr2 td5\"><P class=\"p1 ft3\">[BALANCE_PERCENT] balance payment [BALANCE_AMOUNT] due [BALANCE_WHEN] in [BALANCE_MODE]</P></TD>
            <TD class=\"tr2 td6\"><P class=\"p6 ft8\">Tax due</P></TD>
            <TD class=\"tr2 td7\"><P class=\"p5 ft8\">[TAX_AMOUNT]</P></TD>
            <TD class=\"tr2 td8\"><P class=\"p0 ft0\">&nbsp;</P></TD>
        </TR>
        <TR>
            <TD class=\"tr5 td4\"><P class=\"p0 ft0\">&nbsp;</P></TD>
            <TD class=\"tr5 td5\"><P class=\"p1 ft4\">[ADDITIONAL_COMMENTS]</P></TD>
            <TD class=\"tr6 td14\"><P class=\"p6 ft9\">Other</P></TD>
            <TD class=\"tr6 td15\"><P class=\"p5 ft9\">[OTHER_AMOUNT]</P></TD>
            <TD class=\"tr5 td8\"><P class=\"p0 ft0\">&nbsp;</P></TD>
        </TR>
        <TR>
            <TD class=\"tr2 td4\"><P class=\"p0 ft0\">&nbsp;</P></TD>
            <TD class=\"tr2 td5\"><P class=\"p0 ft0\">&nbsp;</P></TD>
            <TD class=\"tr2 td26\"><P class=\"p5 ft10\">TOTAL</P></TD>
            <TD class=\"tr4 td27\"><P class=\"p4 ft10\">[TOTAL_AMOUNT]</P></TD>
            <TD class=\"tr2 td8\"><P class=\"p0 ft0\">&nbsp;</P></TD>
        </TR>
        <TR>
            <TD class=\"tr2 td28\"><P class=\"p0 ft0\">&nbsp;</P></TD>
            <TD class=\"tr2 td13\"><P class=\"p0 ft0\">&nbsp;</P></TD>
            <TD class=\"tr2 td14\"><P class=\"p0 ft0\">&nbsp;</P></TD>
            <TD class=\"tr2 td15\"><P class=\"p0 ft0\">&nbsp;</P></TD>
            <TD class=\"tr2 td29\"><P class=\"p0 ft0\">&nbsp;</P></TD>
        </TR>
    </TABLE>
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
          DELETE FROM `Template` WHERE  `type_id`=2;
        ");
    }
}
