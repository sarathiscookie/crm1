<style>
    body {
        margin: 0;
        padding: 0;
        font-family: Helvetica, sans-serif;

    }
    table {
        width: 100%;
        font-size: 11px;
        table-layout:fixed;
    }
</style>
<page backtop="30mm" backbottom="10mm" backleft="0mm" backright="0mm">
    <page_header>
        <table style="width: 100%;" cellpadding="0" cellspacing="0">
            <tr>
                <td style="align-content: center;"><img src="{{ public_path() }}/assets/admin/img/invoice_header.png" style="width: 100%;"></td>
            </tr>
        </table>
    </page_header>
    <page_footer>
        <table style="width: 100%;" cellpadding="0" cellspacing="0">
            <tr>
                <td style="align-content: center; position:absolute; bottom:0px;"><img src="{{ public_path() }}/assets/admin/img/invoice_footer.png" style="width: 100%;"></td>
            </tr>
        </table>
    </page_footer>
    <table style="width: 1000px; padding: 30px 60px; margin-top: 70px;">
        <tr>
            <td style="width: 50%">
                <span style="font-size: 8px; text-decoration: underline;">Registeranzeiger GmbH &bull; Alfons-Auer-Straße 8f &bull; 93053 Regensburg</span><br>
                {!! $invoice['invoice_address'] !!}
            </td>
            <td align="right">
                <span style="font-size: 20px; font-weight: bold;">Voucher</span><br>
                Kundennummer: {{ $invoice['customer_number'] }} <br>
                Rechnungsnummer: {{ $invoice['invoice_number'] }} <br>
                Rech.-/Lieferdatum: {{ $invoice['invoice_date'] }} <br>
            </td>
        </tr>
    </table>
    <table style="width: 100%; padding: 30px 60px; border-spacing: 10px; border-collapse: separate; *border-collapse: expression('separate', cellSpacing = '10px');">
        <thead>
        <tr>
            <th align="center" style="padding: 12px;"></th>
            <th align="left" style="width: 370px; padding: 12px;">Artikelbezeichnung</th>
        </tr>
        </thead>
        <tbody>

        {!! $invoice['booking_data'] !!}

        <tr>
            <td colspan="2" style="padding: 12px;">Invoice without prices</td>
        </tr>
        </tbody>
    </table>
    <table style="width: 100%; padding: 10px 60px; border-spacing: 10px;">
        <thead>
        <tr>
            <td><span style="padding-bottom:10px; font-size: 20px; font-weight: bold;">Passengers</span></td>
        </tr>
        </thead>
        <tbody>
        @forelse($passengers as $passenger)
            <tr>
                <td valign="top" align="left" style="width:200px; padding: 5px 12px;">{{ title_case($passenger->firstname) }} {{ title_case($passenger->lastname) }}</td>
            </tr>
        @empty
            <tr><td><p>No passengers</p></td></tr>
        @endforelse
        </tbody>
    </table>
</page>