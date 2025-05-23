<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use App\Models\ArmadaTicket;

class resetFormValidatebyTicketCode extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'armadaticket:resetvalidateform';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset Validasi Form';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        DB::beginTransaction();
        $array_armada_ticket_to_revalidate = ["P02-JBR0-0806220399","P02-BDS0-0906220431","P02-MAD1-2406220550","P02-TGR1-2706220562","P02-JBD0-2906220576","P02-KTC1-3105220030","P02-TTI1-3105220032","P02-GNS1-3105220033","P02-LGS1-0206220001","P02-MEU1-0206220002","P02-TKG1-0206220003","P02-MAU1-0206220004","P02-SBW1-0206220005","P02-RTG1-0206220006","P02-TNT1-0206220007","P02-JYP1-0206220008","P02-TAR1-0206220009","P02-LHO1-0206220013","P02-PS11-0206220014","P02-UGB1-0206220015","P02-BNA1-0206220016","P02-JKB1-0206220019","P02-TOL1-0206220010","P02-SGR1-0206220021","P02-JUP1-0206220023","P02-TJM1-0206220024","P02-TJM1-0206220025","P02-BMA1-0206220026","P02-BWS1-0306220036","P02-BWS1-0306220037","P02-PBN1-0306220038","P02-TGL1-0306220040","P02-TGL1-0306220041","P02-MGL1-0306220046","P02-PRW1-0306220035","P02-BLA1-0306220048","P02-MGL1-0306220049","P02-PRW1-0306220050","P02-MGL1-0306220052","P02-BPP1-0306220051","P02-BPP1-0306220053","P02-CPS1-0306220047","P02-MNB1-0306220058","P02-BBS1-0306220057","P02-BKL1-0306220059","P02-LPG1-0306220060","P02-SBP1-0306220064","P02-KPG1-0306220071","P02-BBS1-0306220067","P02-SLT1-0306220063","P02-PMK1-0306220070","P02-SLT1-0306220075","P02-BBS1-0306220074","P02-SLT1-0306220076","P02-SPT1-0306220079","P02-LLG1-0306220081","P02-BRB1-0306220085","P02-TKA1-0306220084","P02-SMP1-0306220083","P02-LLG1-0306220087","P02-SLO1-0306220093","P02-KRW0-0306220092","P02-KBM1-0306220095","P02-MLU0-0306220096","P02-KBM1-0306220097","P02-LPG0-0306220086","P02-PTT1-0306220090","P02-MLU0-0306220100","P02-YGY1-0306220027","P02-PTT0-0306220104","P02-YGY1-0306220028","P02-PBL1-0306220101","P02-PBL1-0306220103","P02-LHT1-0306220107","P02-BJS1-0306220099","P02-BNR1-0306220115","P02-PTB1-0306220114","P02-BJB1-0306220105","P02-TWG1-0306220102","P02-STB1-0306220119","P02-STB1-0306220120","P02-SLM1-0306220125","P02-TMG1-0306220126","P02-TMG1-0306220127","P02-TMG1-0306220129","P02-KRY1-0306220132","P02-TSK0-0306220137","P02-BDU1-0306220139","P02-MND1-0306220133","P02-MJK1-0306220143","P02-PMN1-0306220088","P02-YGY0-0306220145","P02-YGY0-0306220146","P02-MJL1-0306220147","P02-KRG1-0306220151","P02-PBM1-0306220148","P02-BYL1-0306220149","P02-BYL1-0306220150","P02-PRY1-0306220153","P02-SLG1-0306220155","P02-SLG1-0306220156","P02-SLG1-0306220157","P02-PWD1-0306220160","P02-PLU1-0306220159","P02-JBT1-0306220140","P02-SLO0-0306220162","P02-BGL1-0306220163","P02-SLO0-0306220166","P02-BGL1-0306220164","P02-BGL0-0306220167","P02-PLU1-0306220165","P02-STG1-0306220152","P02-TLG1-0306220168","P02-BLK1-0306220171","P02-BLK1-0306220173","P02-TSK1-0306220136","P02-PDU1-0306220175","P02-PDU1-0306220176","P02-TGS1-0306220177","P02-JBR1-0306220183","P02-MLP1-0306220180","P02-PNB1-0306220181","P02-TRK1-0306220158","P02-JBR1-0306220187","P02-CMS1-0306220188","P02-MAD1-0306220189","P02-KDS1-0306220192","P02-BRB1-0306220190","P02-GDG1-0306220195","P02-MLU1-0306220194","P02-GDG1-0306220198","P02-GDG1-0306220200","P02-SRG1-0306220202","P02-BTS1-0306220193","P02-PWK1-0306220178","P02-PWK1-0306220179","P02-KBM1-0306220094","P02-WNM1-0306220211","P02-PSP1-0306220209","P02-PDG1-0306220121","P02-WNM1-0306220213","P02-SBY1-0406220218","P02-LMJ1-0406220219","P02-LMJ1-0406220220","P02-SGM1-0406220224","P02-PML1-0306220174","P02-SMD1-0406220235","P02-SMT1-0406220239","P02-RKS1-0306220217","P02-DPK1-0406220238","P02-SMT1-0406220240","P02-SBU1-0406220244","P02-SBU1-0406220245","P02-MJA1-0406220246","P02-RAP1-0406220252","P02-LSM1-0406220257","P02-CLD1-0406220271","P02-CLD1-0406220272","P02-GSK1-0406220273","P02-WLI1-0406220276","P02-PBG1-0406220281","P02-KLN1-0306220056","P02-CMI1-0406220285","P02-MET1-0406220286","P02-CKP1-0406220298","P02-TSK1-0406220301","P02-KTB1-0606220306","P02-BWI1-0606220309","P02-CBD1-0606220310","P02-PWT1-0406220267","P02-PWT1-0406220277","P02-PRY1-0606220313","P02-JWN1-0606220315","P02-JWN1-0606220320","P02-MET1-0406220287","P02-PLB0-0606220325","P02-KRW1-0606220323","P02-JKT1-0606220329","P02-JKT1-0606220332","P02-JKT1-0606220333","P02-JKT1-0606220334","P02-DMK1-0606220330","P02-DMK1-0606220331","P02-MGL1-0306220138","P02-PML1-0606220339","P02-PML1-0606220340","P02-PKL1-0606220317","P02-PKL1-0606220318","P02-CPD1-0606220343","P02-KRW1-0606220322","P02-MDU1-0606220338","P02-MDU1-0606220341","P02-CJR1-0606220321","P02-YGY1-0306220029","P02-YGY1-0306220030","P02-YGY0-0306220141","P02-YGY0-0306220142","P02-YGY0-0306220144","P02-CJR1-0606220348","P02-CJR1-0606220351","P02-RDK1-0606220350","P02-CJR1-0606220352","P02-MBG1-0606220354","P02-SKB1-0606220355","P02-SKB1-0606220356","P02-SLO1-0306220091","P02-BLN1-0606220362","P02-SLM1-0306220124","P02-JTB1-0606220364","P02-KDR1-0606220366","P02-JTB1-0606220365","P02-KDR1-0606220367","P02-KDR1-0606220368","P02-PWD1-0306220169","P02-SRG0-0706220366","P02-SWI1-0706220367","P02-CBT1-0706220369","P02-CBT1-0706220371","P02-CKR1-0706220372","P02-BKS1-0706220373","P02-BKS1-0706220375","P02-BKS1-0706220376","P02-PGE1-0706220374","P02-LSI1-0706220370","P02-LSI1-0706220377","P02-CRB1-0706220369","P02-MPR1-0706220378","P02-MLS1-0706220382","P02-BKO1-0706220386","P02-BKO1-0706220387","P02-PDL1-0806220391","P02-BLT1-0806220395","P02-JBD0-0806220401","P02-GTG1-0806220402","P02-SKB0-0606220357","P02-PLP1-0806220402","P02-DPS1-0806220408","P02-DPS1-0806220409","P02-DPS1-0806220410","P02-DPS1-0806220411","P02-DPS1-0806220412","P02-MKS1-0906220416","P02-SMD1-0406220236","P02-GRT1-0906220424","P02-SBG1-0906220425","P02-SOR1-0906220427","P02-GRT1-0906220423","P02-UJB1-0906220429","P02-KYA1-0906220440","P02-PLB1-0806220413","P02-PLB1-0806220414","P02-KLK1-1006220457","P02-BKT1-1006220459","P02-MKU1-1106220462","P02-PBU1-1106220467","P02-PBU1-1106220465","P02-MDB1-1306220472","P02-PLK1-0306220089","P02-PKL1-0606220316","P02-MTR0-1406220476","P02-SBU1-0406220242","P02-SGR1-0206220020","P02-KTP1-1406220480","P02-CMI1-0606220346","P02-HOBDG1-1406220481","P02-PBI1-1406220486","P02-TLS1-1506220488","P02-RTP1-1506220489","P02-SLM1-0306220123","P02-TMG1-0306220130","P02-PWR1-0406220283","P02-KNG1-1506220492","P02-PPN1-1506220495","P02-CPR1-1506220501","P02-CPR1-1506220502","P02-BTA1-0306220191","P02-PYB1-1606220506","P02-PBI1-1706220507","P02-BDB1-0906220428","P02-PPN1-1506220494","P02-TGR1-0406220300","P02-MDN0-2206220530","P02-TGA1-1506220493","P02-TLN1-2806220567","P02-KJO1-0107220004","P02-KRG1-0107220013","P02-KDI0-0107220020","P02-PBM1-0107220018","P02-JKB1-0107220032","P02-LWK1-0107220046","P02-RDK1-0107220059","P02-RDK1-0107220060","P02-RDK1-0107220061","P02-SRG0-0207220072","P02-SMG1-0207220074","P02-KBM1-0207220077","P02-KBM1-0207220078","P02-SMG1-0207220079","P02-CWI1-0107220001","P02-SLK1-0207220082","P02-SLK1-0207220083","P02-PWD1-0207220085","P02-PWD1-0207220086","P02-BDU1-0207220090","P02-PWT0-0207220100","P02-TGL1-0207220107","P02-TGL0-0207220109","P02-PMK1-0407220118","P02-MAD1-0407220122","P02-MAD1-0407220123","P02-RKS1-0207220110","P02-BKS1-0407220147","P02-KIS1-0407220156","P02-PRY1-0407220160","P02-MAR1-0407220168","P02-SMT1-0407220170","P02-UNR1-0407220171","P02-SMT1-0407220176","P02-SMT1-0407220177","P02-SMT1-0407220178","P02-JBD0-0407220179","P02-SPT1-0407220181","P02-GSK0-0407220184","P02-GSK1-0407220185","P02-JBD0-0407220203","P02-JBD0-0407220204","P02-JBD0-0407220205","P02-SKB1-0407220219","P02-KDS1-0407220220","P02-KDS1-0407220222","P02-SKB1-0407220226","P02-KDS1-0407220227","P02-PNG1-0407220231","P02-KDS1-0407220232","P02-BWI1-0407220238","P02-PBN1-0407220245","P02-MND1-0607220317","P02-PSR1-0607220318","P02-SKB1-0607220332","P02-SKB1-0607220334","P02-GDG1-0607220335","P02-GDG1-0607220336","P02-GTG1-0607220339","P02-SMG0-0607220340","P02-BTG1-0707220351","P02-JKB1-2405220015","P02-JBR0-0306220154","P02-JBD0-2906220575"];
        try {
            $facility_revalidate_count = 0;
            $perpanjangan_revalidate_count = 0;
            $mutasi_revalidate_count = 0;
            $armada_tickets = ArmadaTicket::whereIn('code', $array_armada_ticket_to_revalidate)->get();
            foreach ($armada_tickets as $armada_ticket) {
                if (isset($armada_ticket->facility_form)) {
                    $facility_form = $armada_ticket->facility_form;
                    $facility_form->is_form_validated = false;
                    $facility_form->validated_at = null;
                    $facility_form->validated_by = null;
                    $facility_form->save();
                    $facility_revalidate_count++;
                }
                if (isset($armada_ticket->perpanjangan_form)) {
                    $perpanjangan_form = $armada_ticket->perpanjangan_form;
                    $perpanjangan_form->is_form_validated = false;
                    $perpanjangan_form->validated_at = null;
                    $perpanjangan_form->validated_by = null;
                    $perpanjangan_form->save();
                    $perpanjangan_revalidate_count++;
                }
                if (isset($armada_ticket->mutasi_form)) {
                    $mutasi_form = $armada_ticket->mutasi_form;
                    $mutasi_form->is_form_validated = false;
                    $mutasi_form->validated_at = null;
                    $mutasi_form->validated_by = null;
                    $mutasi_form->save();
                    $mutasi_revalidate_count++;
                }
            }
            DB::commit();
            print("facility_revalidate_count : ".$facility_revalidate_count."\n");
            print("perpanjangan_revalidate_count : ".$perpanjangan_revalidate_count."\n");
            print("mutasi_revalidate_count : ".$mutasi_revalidate_count."\n");
        } catch (\Exception $ex) {
            print('error : '.$ex->getMessage());
            DB::rollback();
        }
    }
}
