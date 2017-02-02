<?php
/**
 * Class TemplatesService file
 *
 * @author Alex Makhorin
 */
namespace Acted\LegalDocsBundle\Services;

use Acted\LegalDocsBundle\Entity\Template;
/**
 * Class RequestQuotationTypeService
 * @package Wmds\FrontBundle\Services
 * @author Sergey Gulidov
 */
class RequestQuotationTypeService extends base\TemplatesService
{

    /**
     * @var \Acted\LegalDocsBundle\Entity\QuotationType
     */
    protected $_data;

    protected function getTemplateId()
    {
        return Template::TYPE_REQUEST_QUOTATION;
    }

    public function services()
    {
        $serviceTemplate = '';

        if (empty($this->_data['services'])) {
            return $serviceTemplate;
        }

        $tableStyle = "style='border-collapse: collapse;font-size: 1em;width:100%'";
        $thStyle = "style='border-collapse: collapse;font-size: 3em;width:100%'";
        $tdStyle = "style='border: 1px solid #dddddd;font-size: 3em; text-align: left; padding: 8px;'";

        foreach ($this->_data['services'] as $service) {

            $serviceTitle = $service['title'];
            $serviceTemplate = "<table $tableStyle>
                <tr>
                    <th $thStyle >service title</th>
                    <th $thStyle >is visible service</th>
                    <th $thStyle >package name</th>
                    <th $thStyle >option duration</th>
                    <th $thStyle >option qty</th>
                    <th $thStyle >option price on request</th>
                    <th $thStyle >price amount</th>
                  </tr>";

            $serviceIsVisible = $service['isVisible'];

            foreach ($service['packages'] as $package) {

                $packageName = $package['name'];

                foreach ($package['options'] as $option) {

                    $duration = $option['duration'];
                    $qty = $option['qty'];
                    $priceOnRequest = $option['priceOnRequest'];

                    foreach ($option['rates'] as $rate) {

                        $amount = $rate['price']['amount'];

                        $serviceTemplate .= "<tr>
                            <td $tdStyle >$serviceTitle</td>
                            <td $tdStyle >$serviceIsVisible</td>
                            <td $tdStyle >$packageName</td>
                            <td $tdStyle >$duration</td>
                            <td $tdStyle >$qty</td>
                            <td $tdStyle >$priceOnRequest</td>
                            <td $tdStyle >$amount</td>
                        </tr>";
                    }
                }
            }
            $serviceTemplate .= "</table>";
        }

        return $serviceTemplate;
    }

    public function performances()
    {
        $performanceTemplate = '';

        if (empty($this->_data['performances'])) {
            return $performanceTemplate;
        }

        $tableStyle = "style='border-collapse: collapse;font-size: 1em;width:100%'";
        $thStyle = "style='border-collapse: collapse;font-size: 3em;width:100%'";
        $tdStyle = "style='border: 1px solid #dddddd;font-size: 3em; text-align: left; padding: 8px;'";

        foreach ($this->_data['performances'] as $performance) {
            $performanceTitle = $performance['title'];

            //$performanceTemplate .= "<table><tr><td>$performanceTitle</td></tr></table>";
            $performanceTemplate = "<table $tableStyle >
                <tr>
                    <th $thStyle >performance title</th>
                    <th $thStyle >is visible performance</th>
                    <th $thStyle >package name</th>
                    <th $thStyle >option duration</th>
                    <th $thStyle >option qty</th>
                    <th $thStyle >option price on request</th>
                    <th $thStyle >price amount</th>
                  </tr>";

            $performanceIsVisible = $performance['isVisible'];

            foreach ($performance['packages'] as $package) {

                $packageName = $package['name'];

                foreach ($package['options'] as $option) {

                    $duration = $option['duration'];
                    $qty = $option['qty'];
                    $priceOnRequest = $option['priceOnRequest'];

                    foreach ($option['rates'] as $rate) {

                        $amount = $rate['price']['amount'];

                        $performanceTemplate .= "<tr>
                            <td $tdStyle >$performanceTitle</td>
                            <td $tdStyle >$performanceIsVisible</td>
                            <td $tdStyle >$packageName</td>
                            <td $tdStyle >$duration</td>
                            <td $tdStyle >$qty</td>
                            <td $tdStyle >$priceOnRequest</td>
                            <td $tdStyle >$amount</td>
                        </tr>";
                    }
                }
            }
            $performanceTemplate .= "</table>";
        }

        //print_r($performanceTemplate);exit;
        return $performanceTemplate;
    }

    public function event()
    {
        if (empty($this->_data['event'])) {
            throw new TemplateDataMissingException(__FUNCTION__);
        }

        $tableStyle = "style='border-collapse: collapse;font-size: 1em;width:100%'";
        $thStyle = "style='border-collapse: collapse;font-size: 3em;width:100%'";
        $tdStyle = "style='border: 1px solid #dddddd;font-size: 3em; text-align: left; padding: 8px;'";

        $title = $this->_data['event']['title'];
        $location = $this->_data['event']['location'];


        $startingDate = $this->_data['event']['startingDate'];
        $endingDate = $this->_data['event']['endingDate'];

        if (!empty($startingDate)) {
            $startingDate = $startingDate->format('Y-m-d-H:i:s');
        }

        if (!empty($endingDate)) {
            $endingDate = $endingDate->format('Y-m-d-H:i:s');
        }


        $timing = $this->_data['event']['timing'];
        $numberOfGuests = $this->_data['event']['numberOfGuests'];
        $city = $this->_data['event']['city'];
        $clientFirstname = $this->_data['event']['clientFirstname'];
        $clientLastname = $this->_data['event']['clientLastname'];
        $venueType = $this->_data['event']['venueType'];

        $eventTemplate = "<table $tableStyle >
                <tr>
                    <th $thStyle >title</th>
                    <th $thStyle >location</th>
                    <th $thStyle >starting_date</th>
                    <th $thStyle >ending_date</th>
                    <th $thStyle >timing</th>
                    <th $thStyle >number_of_guests</th>
                    <th $thStyle >city</th>
                    <th $thStyle >client_firstname</th>
                    <th $thStyle >client_lastname</th>
                    <th $thStyle >venue_type</th>
                  </tr>
                  <tr>
                    <td $tdStyle >$title</td>
                    <td $tdStyle >$location</td>
                    <td $tdStyle >$startingDate</td>
                    <td $tdStyle >$endingDate</td>
                    <td $tdStyle >$timing</td>
                    <td $tdStyle >$numberOfGuests</td>
                    <td $tdStyle >$city</td>
                    <td $tdStyle >$clientFirstname</td>
                    <td $tdStyle >$clientLastname</td>
                    <td $tdStyle >$venueType</td>
                  </tr>
                 </table>";

        return $eventTemplate;
    }


    public function payment_term()
    {
        if (empty($this->_data['payment_term'])) {
            throw new TemplateDataMissingException(__FUNCTION__);
        }

        $tableStyle = "style='border-collapse: collapse;font-size: 1em;width:100%'";
        $thStyle = "style='border-collapse: collapse;font-size: 0.5em;width:100%'";
        $tdStyle = "style='border: 1px solid #dddddd;font-size: 0.5em; text-align: left; padding: 8px;'";

        $balancePercent = $this->_data['payment_term']['balance_percent'];

        $paymentTemplate = "<table $tableStyle >
                <tr>
                    <th $thStyle >Balance percent</th>
                  </tr>
                  <tr>
                    <td $tdStyle >$balancePercent</td>
                  </tr>
                 </table>";

        return $paymentTemplate;
    }

    public function generateDocumentPdf($chatRoomId, $requestQuotationId)
    {
        $date = new \DateTime();
        $fileName = implode('_', ['Official_Quotation', $date->format('Ymd-His'), $chatRoomId, $requestQuotationId]);
        $fileName .= '.pdf';
        $documentDir = uniqid() . '/';

        $dir = dirname($this->getSavePath($fileName));

        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
            chmod($dir, 0777);
        }

        $this->_mpdfService->generatePdf($this->_parsedTemplate, [
            'outputFilename' => $dir.'/'.$fileName,
            'outputDest' => 'F',
        ]);

        return $this->dir.'/'.$fileName;
    }

}