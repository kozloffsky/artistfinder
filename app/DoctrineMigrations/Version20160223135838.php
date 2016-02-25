<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160223135838 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql("
            INSERT INTO `Template` (`type_id`, `template`, `is_active`) VALUES (1,
                '<!DOCTYPE html>
                <html lang=\"en\">
                <head>
                    <meta charset=\"UTF-8\">
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
                <table cellpadding=\"0\" cellspacing=\"0\">
                    <tr>
                        <td><p>[ARTIST_NAME]</p></td>
                        <td><p>&nbsp;</p></td>
                        <td><p>[CLIENT_NAME]</p></td>
                    </tr>
                </table>
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
          DELETE FROM `Template` WHERE  `type_id`=1;
        ");

    }
}
