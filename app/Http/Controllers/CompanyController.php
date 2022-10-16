<?php



namespace App\Http\Controllers;



use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use Illuminate\Pagination\Paginator;

use Illuminate\Support\Facades\Storage;

use App\Models\Admin;

use App\Models\User;

use Illuminate\Http\File;

use Auth;

use Session;



class CompanyController extends Controller

{

  public function __construct()
  {

    $this->page_title = 'Admin Panel';
  }

  public function index()
  {
    $user_id = Auth::user()->id;
    Paginator::useBootstrap();
    $result = DB::table('users_companyinfo')->where('user_id', $user_id)->orderBy('id', 'DESC')->get();
    return view('backend.company.index', [
      'page_title' => $this->page_title,
      'page_header' => 'Company Info',
    ], with(compact('result')));
  }


  /**

   * Add a New 

   *

   * @param array $request  Input values

   * @return redirect     to  view

   */

  public function add(Request $request)

  {



    if (!$_POST) {



      return view('backend.company.add', [

        'page_title' => $this->page_title,

        'page_header' => 'Add New Company',



      ]);
    } else if ($request->submit) {

      $validatedData = $request->validate(['kvkNumber' => 'required']);
      $post['user_id'] = Auth::user()->id;
      $kvkNumber = $request->kvkNumber;
      $kvkNumber = str_replace(array(' ', '.', '-', ',', ', '), '', trim($kvkNumber));
      $contents = @file_get_contents('https://developers.kvk.nl/test/api/v1/basisprofielen/' . $kvkNumber . '?geoData=true');
      $dataResult = json_decode($contents);
      // print_r($dataResult); exit;

      if ($dataResult) :

        $dataExist = DB::table('users_companyinfo')->where('user_id', Auth::user()->id)->where('kvkNumber', $kvkNumber)->get();

        if (count($dataExist)) :
          $notification = array(
            'status' => 'Company Information Already Exist',
            'alert-type' => 'error'
          );
        else :

          $post['kvkNumber'] = $dataResult->kvkNummer;
          $post['indNonMailing'] = $dataResult->indNonMailing;
          $post['uniqueCompanyId'] = Auth::user()->id . '' . random_int(100, 999);
          $post['name']  = $dataResult->naam;
          $post['formalRegistrationDate']   = $dataResult->formeleRegistratiedatum;
          $post['commencementDate']      = $dataResult->materieleRegistratie->datumAanvang;
          $post['totalEmployedPersons'] = $dataResult->totaalWerkzamePersonen;
          $post['tradeName1'] = $dataResult->handelsnamen[0]->naam;
          $post['order1'] = $dataResult->handelsnamen[0]->volgorde;
          $post['tradeName2'] = $dataResult->handelsnamen[1]->naam;
          $post['order2'] = $dataResult->handelsnamen[1]->volgorde;
          $post['tradeName3'] = $dataResult->handelsnamen[2]->naam;
          $post['order3'] = $dataResult->handelsnamen[2]->volgorde;
          $post['tradeName4'] = $dataResult->handelsnamen[3]->naam;
          $post['order4'] = $dataResult->handelsnamen[3]->volgorde;
          $post['sbiCode1'] = $dataResult->sbiActiviteiten[0]->sbiCode;
          $post['sbiDescription1'] = $dataResult->sbiActiviteiten[0]->sbiOmschrijving;
          $post['indMainActivity1']  = $dataResult->sbiActiviteiten[0]->indHoofdactiviteit;
          $post['sbiCode2'] = $dataResult->sbiActiviteiten[1]->sbiCode;
          $post['sbiDescription2'] = $dataResult->sbiActiviteiten[1]->sbiOmschrijving;
          $post['indMainActivity2']  = $dataResult->sbiActiviteiten[1]->indHoofdactiviteit;
          $post['sbiCode3'] = $dataResult->sbiActiviteiten[2]->sbiCode;
          $post['sbiDescription3'] = $dataResult->sbiActiviteiten[2]->sbiOmschrijving;
          $post['indMainActivity3']  = $dataResult->sbiActiviteiten[2]->indHoofdactiviteit;
          $post['link_rel1']   = $dataResult->links[0]->rel;
          $post['link_href1']  = $dataResult->links[0]->href;
          $post['link_rel2']   = $dataResult->links[1]->rel;
          $post['link_href2']      = $dataResult->links[1]->href;
          $post['mainBranchLocationNumber'] = $dataResult->_embedded->hoofdvestiging->vestigingsnummer;
          $post['mainBranchkvkNumber'] = $dataResult->_embedded->hoofdvestiging->kvkNummer;
          $post['mainBranchFormalRegistrationDate'] = $dataResult->_embedded->hoofdvestiging->formeleRegistratiedatum;
          $post['mainBranchStartDate'] = $dataResult->_embedded->hoofdvestiging->materieleRegistratie->datumAanvang;
          $post['mainBranchFirstTradeName'] = $dataResult->_embedded->hoofdvestiging->eersteHandelsnaam;
          $post['mainBranchIndHoofdLocation'] = $dataResult->_embedded->hoofdvestiging->indHoofdvestiging;
          $post['mainBranchIndCommercieleLocation'] = $dataResult->_embedded->hoofdvestiging->indCommercieleVestiging;
          $post['mainBranchTotalEmployedPersons'] = $dataResult->_embedded->hoofdvestiging->totaalWerkzamePersonen;
          $post['addressType'] = $dataResult->_embedded->hoofdvestiging->adressen[0]->type;
          $post['addressIndProtected'] = $dataResult->_embedded->hoofdvestiging->adressen[0]->indAfgeschermd;
          $post['addressFullAddress'] = $dataResult->_embedded->hoofdvestiging->adressen[0]->volledigAdres;
          $post['addressStreetName']  = $dataResult->_embedded->hoofdvestiging->adressen[0]->straatnaam;
          $post['addressHouseNumber']   = $dataResult->_embedded->hoofdvestiging->adressen[0]->huisnummer;
          $post['addressHouseLetter']      = $dataResult->_embedded->hoofdvestiging->adressen[0]->huisletter;
          $post['addressPostalCode'] = $dataResult->_embedded->hoofdvestiging->adressen[0]->postcode;
          $post['addressCity'] = $dataResult->_embedded->hoofdvestiging->adressen[0]->plaats;
          $post['addressCountry'] = $dataResult->_embedded->hoofdvestiging->adressen[0]->land;
          $post['geoDataAddressableObjectId'] = $dataResult->_embedded->hoofdvestiging->adressen[0]->geoData->addresseerbaarObjectId;
          $post['geoDataNumberDesignationId'] = $dataResult->_embedded->hoofdvestiging->adressen[0]->geoData->nummerAanduidingId;
          $post['geoDataGpsLatitude'] = $dataResult->_embedded->hoofdvestiging->adressen[0]->geoData->gpsLatitude;
          $post['geoDataGpsLongitude'] = $dataResult->_embedded->hoofdvestiging->adressen[0]->geoData->gpsLongitude;
          $post['geoDataReichtriangleX'] = $dataResult->_embedded->hoofdvestiging->adressen[0]->geoData->rijksdriehoekX;
          $post['geoDataReichtriangleY'] = $dataResult->_embedded->hoofdvestiging->adressen[0]->geoData->rijksdriehoekY;
          $post['geoDataReichtriangleZ'] = $dataResult->_embedded->hoofdvestiging->adressen[0]->geoData->rijksdriehoekZ;
          $post['links_rel1'] = $dataResult->_embedded->hoofdvestiging->links[0]->rel;
          $post['links_href1']  = $dataResult->_embedded->hoofdvestiging->links[0]->href;
          $post['links_rel2'] = $dataResult->_embedded->hoofdvestiging->links[1]->rel;
          $post['links_href2']  = $dataResult->_embedded->hoofdvestiging->links[1]->href;
          $post['links_rel3'] = $dataResult->_embedded->hoofdvestiging->links[2]->rel;
          $post['links_href3']  = $dataResult->_embedded->hoofdvestiging->links[2]->href;
          $post['links_rel4'] = $dataResult->_embedded->hoofdvestiging->links[3]->rel;
          $post['links_href4']  = $dataResult->_embedded->hoofdvestiging->links[3]->href;
          // $post['ownerLegalForm'] = $dataResult->_embedded->hoofdvestiging->eigenaar->rechtsvorm;
          // $post['ownerExtendedLegalForm'] = $dataResult->_embedded->hoofdvestiging->eigenaar->uitgebreideRechtsvorm;
          // $post['owner_links_rel1']  = $dataResult->_embedded->hoofdvestiging->eigenaar->links[0]->rel;
          //  $post['owner_links_href1'] = $dataResult->_embedded->hoofdvestiging->eigenaar->links[0]->href;
          //  $post['owner_links_rel2']  = $dataResult->_embedded->hoofdvestiging->eigenaar->links[1]->rel;
          //  $post['owner_links_href2'] = $dataResult->_embedded->hoofdvestiging->eigenaar->links[1]->href;


          $insertData = DB::table('users_companyinfo')->insert($post);
          $notification = array(
            'status' => 'Company Information Saved Successfully',
            'alert-type' => 'success'
          );

        endif;
      else :
        $notification = array(
          'status' => 'Invalid kvkNumberNumber',
          'alert-type' => 'error'
        );

      endif;

      return redirect()->back()->with($notification);
    } else {

      $notification = array(

        'status' => 'You are not allowed to access',

        'alert-type' => 'error'

      );

      return redirect()->back()->with($notification);
    }
  }

  public function add2(Request $request)
  {

    if (!$_POST) {

      return view('backend.company.add2', [
        'page_title' => $this->page_title,
        'page_header' => 'Add New Company',
      ]);
    } else if ($request->submit) {

      $validatedData = $request->validate([
        'kvkNumber'    => 'required',
        'company_name' => 'required',
      ]);


      $kvkNumber = $request->kvkNumber;
      $dataExist = DB::table('users_companyinfo')->where('user_id', Auth::user()->id)->where('kvkNumber', $kvkNumber)->get();
      if (count($dataExist)) :
        $notification = array(
          'status' => 'Company Information Already Exist',
          'alert-type' => 'error'
        );
      else :

        $post = array();
        $post['user_id'] = Auth::user()->id;
        $post['kvkNumber'] = $kvkNumber;
        $post['indNonMailing'] = $request->indNonMailing;
        $post['name']  = $request->company_name;

        $post['taxiLicience']  = $request->taxiLicience;
        $post['taxiCompanyLicience']   = $request->taxiCompanyLicience;
        $post['taxiDrivingLicience']      = $request->taxiDrivingLicience;
        $post['companyWebsite'] = $request->companyWebsite;
        $post['email'] = $request->email;
        $post['notes'] = $request->notes;

        if (!empty($request->companyProfilePicture)) :
          $docFile = 'companyProfilePicture_' . time() . '.' . $request->companyProfilePicture->extension();
          $post['companyProfilePicture'] = $docFile;
          $request->companyProfilePicture->move(public_path('company'), $docFile);
        endif;

        if (!empty($request->logo)) :
          $docFile = 'logo_' . time() . '.' . $request->logo->extension();
          $post['logo'] = $docFile;
          $request->logo->move(public_path('company'), $docFile);
        endif;

        if (!empty($request->favicon)) :
          $docFile = 'favicon_' . time() . '.' . $request->favicon->extension();
          $post['favicon'] = $docFile;
          $request->favicon->move(public_path('company'), $docFile);
        endif;



        $post['kvkNumber']   = $request->kvkNumber;
        $post['name']      = $request->company_name;
        $post['addressPostalCode'] = $request->addressPostalCode;
        $post['addressHouseNumber'] = $request->addressHouseNumber;
        $post['addressStreetName'] = $request->addressStreetName;
        $post['addressCity'] = $request->addressCity;
        $post['uniqueCompanyId'] = Auth::user()->id . '' . random_int(100, 999);
        $post['county'] = $request->county;
        $post['taxiLicience'] = $request->taxiLicience;
        $post['taxiCompanyLicience'] = $request->taxiCompanyLicience;
        $post['taxiDrivingLicience'] = $request->taxiDrivingLicience;
        $post['companyWebsite'] = $request->companyWebsite;
        $post['email'] = $request->email;
        $post['notes'] = $request->notes;




        $insertData = DB::table('users_companyinfo')->insert($post);
        $notification = array(
          'status' => 'Company Information Saved Successfully',
          'alert-type' => 'success'
        );

      endif;


      return redirect()->back()->with($notification);
    } else {
      $notification = array(
        'status' => 'You are not allowed to access',
        'alert-type' => 'error'
      );

      return redirect()->back()->with($notification);
    }
  }


  /**

   * Update  Details

   *

   * @param array $request    Input values

   * @return redirect     to  View

   */

  public function update(Request $request)

  {

    if (!$_POST) {

      $result = DB::table('users_companyinfo')->where('id', $request->id)->first();

      return view('backend.company.edit', [
        'page_title' => $this->page_title,
        'page_header' => 'Update Company Information',
      ], with(compact('result')));
    } else if ($request->submit) {



      $validatedData = $request->validate([

        'kvkNumber'   => 'required',
        'company_name' => 'required',

      ]);



      $id = $request->id;

      $post = array();
      $post['kvkNumber'] = $request->kvkNumber;
      $post['indNonMailing'] = $request->indNonMailing;
      $post['name']  = $request->company_name;

      $post['taxiLicience']  = $request->taxiLicience;
      $post['taxiCompanyLicience']   = $request->taxiCompanyLicience;
      $post['taxiDrivingLicience']      = $request->taxiDrivingLicience;
      $post['companyWebsite'] = $request->companyWebsite;
      $post['email'] = $request->email;
      $post['notes'] = $request->notes;

      if (!empty($request->companyProfilePicture)) :
        $docFile = 'companyProfilePicture_' . time() . '.' . $request->companyProfilePicture->extension();
        $post['companyProfilePicture'] = $docFile;
        $request->companyProfilePicture->move(public_path('company'), $docFile);
      endif;

      if (!empty($request->logo)) :
        $docFile = 'logo_' . time() . '.' . $request->logo->extension();
        $post['logo'] = $docFile;
        $request->logo->move(public_path('company'), $docFile);
      endif;

      if (!empty($request->favicon)) :
        $docFile = 'favicon_' . time() . '.' . $request->favicon->extension();
        $post['favicon'] = $docFile;
        $request->favicon->move(public_path('company'), $docFile);
      endif;


      $post['formalRegistrationDate']   = $request->formalRegistrationDate;
      $post['commencementDate']      = $request->commencementDate;
      $post['totalEmployedPersons'] = $request->totalEmployedPersons;
      $post['tradeName1'] = $request->tradeName1;
      $post['order1'] = $request->order1;
      $post['tradeName2'] = $request->tradeName2;
      $post['order2'] = $request->order2;
      $post['tradeName3'] = $request->tradeName3;
      $post['order3'] = $request->order3;
      $post['tradeName4'] = $request->tradeName4;
      $post['order4'] = $request->order4;
      $post['sbiCode1'] = $request->sbiCode1;
      $post['sbiDescription1'] = $request->sbiDescription1;
      $post['indMainActivity1']  = $request->indMainActivity1;
      $post['sbiCode2'] = $request->sbiCode2;
      $post['sbiDescription2'] = $request->sbiDescription2;
      $post['indMainActivity2']  = $request->indMainActivity2;
      $post['sbiCode3'] = $request->sbiCode3;
      $post['sbiDescription3'] = $request->sbiDescription3;
      $post['indMainActivity3']  = $request->indMainActivity3;

      $post['link_rel1']   = $request->link_rel1;
      $post['link_href1']  = $request->link_href1;
      $post['link_rel2']   = $request->link_rel2;
      $post['link_href2']      = $request->link_href2;
      $post['mainBranchLocationNumber'] = $request->mainBranchLocationNumber;
      $post['mainBranchkvkNumber'] = $request->mainBranchkvkNumber;
      $post['mainBranchFormalRegistrationDate'] = $request->mainBranchFormalRegistrationDate;
      $post['mainBranchStartDate'] = $request->mainBranchStartDate;
      $post['mainBranchFirstTradeName'] = $request->mainBranchFirstTradeName;
      $post['mainBranchIndHoofdLocation'] = $request->mainBranchIndHoofdLocation;
      $post['mainBranchIndCommercieleLocation'] = $request->mainBranchIndCommercieleLocation;
      $post['mainBranchTotalEmployedPersons'] = $request->mainBranchTotalEmployedPersons;
      $post['addressType'] = $request->addressType;
      $post['addressIndProtected'] = $request->addressIndProtected;
      $post['addressFullAddress'] = $request->addressFullAddress;
      $post['addressStreetName']  = $request->addressStreetName;
      $post['addressHouseNumber']   = $request->addressHouseNumber;
      $post['addressHouseLetter']      = $request->addressHouseLetter;
      $post['addressPostalCode'] = $request->addressPostalCode;
      $post['addressCity'] = $request->addressCity;
      $post['addressCountry'] = $request->addressCountry;
      $post['geoDataAddressableObjectId'] = $request->geoDataAddressableObjectId;
      $post['geoDataNumberDesignationId'] = $request->geoDataNumberDesignationId;
      $post['geoDataGpsLatitude'] = $request->geoDataGpsLatitude;
      $post['geoDataGpsLongitude'] = $request->geoDataGpsLongitude;
      $post['geoDataReichtriangleX'] = $request->geoDataReichtriangleX;
      $post['geoDataReichtriangleY'] = $request->geoDataReichtriangleY;
      $post['geoDataReichtriangleZ'] = $request->geoDataReichtriangleZ;
      $post['links_rel1'] = $request->links_rel1;
      $post['links_href1']  = $request->links_href1;
      $post['links_rel2'] = $request->links_rel2;
      $post['links_href2']  = $request->links_href2;
      $post['links_rel3'] = $request->links_rel3;
      $post['links_href3']  = $request->links_href3;
      $post['links_rel4'] = $request->links_rel4;
      $post['links_href4']  = $request->links_href4;

      $updateData = DB::table('users_companyinfo')->where('id', $id)->update($post);



      $notification = array(

        'status' => 'Data Updated Successfully',

        'alert-type' => 'success'

      );

      return redirect()->back()->with($notification);
    }
  }



  /**

   * Delete 

   *

   * @param array $request    Input values

   * @return redirect     to  View

   */

  public function delete(Request $request)

  {

    $delete = DB::table('users_companyinfo')->where('id', $request->id)->delete();

    $notification = array(

      'status' => 'Company Information Deleted Successfully',

      'alert-type' => 'success'

    );

    return redirect()->back()->with($notification);
  }


  /**

   * Delete Vat

   *

   * @param array $request    Input values
 
   * @return redirect     to vehicle View

   */

  public function delete_vat(Request $request)

  {
    $delete = DB::table('users_company_vat')->where('id', $request->id)->delete();
    $notification = array(

      'status' => 'Vat Information Deleted Successfully',

      'alert-type' => 'success'

    );
    return redirect()->back()->with($notification);
  }

  public function vat_check(Request $request)
  {


    if (!$_POST) {
      return view('backend.company.vat_check', [

        'page_title' => $this->page_title,
        'page_header' => 'Verify Vat Information',
      ]);
    } else if ($request->submit) {

      $validatedData = $request->validate(['vatNumber' => 'required']);
      $post['user_id'] = Auth::user()->id;
      $vatNumber = $request->vatNumber;
      $vatNumber = str_replace(array(' ', '.', '-', ',', ', '), '', trim($vatNumber));
      $contents = @file_get_contents('https://controleerbtwnummer.eu/api/validate/' . $vatNumber . '.json');
      $dataResult = json_decode($contents);
      //print_r($dataResult); exit;
      if ($dataResult->valid) :

        $vatNumber2 = $dataResult->vatNumber;
        $dataExist = DB::table('users_company_vat')->where('user_id', Auth::user()->id)->where('vatNumber', $vatNumber2)->get();

        if (count($dataExist)) :
          $notification = array(
            'status' => 'Vat Information Already Exist',
            'alert-type' => 'error'
          );
        else :

          $post['company_name'] = $dataResult->name;
          $post['address_street'] = $dataResult->address->street;
          $post['countryCode']  = $dataResult->countryCode;
          $post['vatNumber']   = $vatNumber2;
          $post['address_number']      = $dataResult->address->number;
          $post['address_zip_code'] = $dataResult->address->zip_code;
          $post['address_city'] = $dataResult->address->city;
          $post['address_country'] = $dataResult->address->country;
          $post['strAddress'] = $dataResult->strAddress;
          $post['isValid'] = $dataResult->valid;

          $insertData = DB::table('users_company_vat')->insert($post);
          $notification = array(
            'status' => 'Vat Information Saved Successfully',
            'alert-type' => 'success'
          );

        endif;
      else :
        $notification = array(
          'status' => 'Invalid Vat Number',
          'alert-type' => 'error'
        );

      endif;

      return redirect()->back()->with($notification);
    }
  }

  public function vat_check2(Request $request)
  {


    if (!$_POST) {
      return view('backend.company.vat_check2', [
        'page_title' => $this->page_title,
        'page_header' => 'Verify Vat Information',
      ]);
    } else if ($request->submit) {

      $validatedData = $request->validate([
        'company_name'   => 'required',
        'address_street' => 'required',
        'vatNumber'      => 'required',
        'address_number' => 'required',
      ]);

      $vatNumber = $request->vatNumber;
      $dataExist = DB::table('users_company_vat')->where('user_id', Auth::user()->id)->where('vatNumber', $vatNumber)->get();

      if (count($dataExist)) :
        $notification = array(
          'status' => 'Vat Information Already Exist',
          'alert-type' => 'error'
        );
      else :

        $post = array();
        $post['user_id'] = Auth::user()->id;
        $post['company_name']   = $request->company_name;
        $post['address_street'] = $request->address_street;
        $post['countryCode']    = $request->countryCode;
        $post['vatNumber']      = $vatNumber;
        $post['address_number'] = $request->address_number;
        $post['address_zip_code'] = $request->address_zip_code;
        $post['address_city']     = $request->address_city;
        $post['address_country']  = $request->address_country;
        $post['strAddress']       = $request->strAddress;
        $post['isValid'] = 1;

        $insertData = DB::table('users_company_vat')->insert($post);
        $notification = array(
          'status' => 'Vat Information Saved Successfully',
          'alert-type' => 'success'
        );
      endif;

      return redirect()->back()->with($notification);
    }
  }

  public function vat_update(Request $request)

  {

    if (!$_POST) {

      $result = DB::table('users_company_vat')->where('id', $request->id)->first();

      return view('backend.company.vat_edit', [
        'page_title' => $this->page_title,
        'page_header' => 'Update Vat Information',
      ], with(compact('result')));
    } else if ($request->submit) {

      $validatedData = $request->validate([
        'company_name'   => 'required',
        'address_street' => 'required',
        'vatNumber'      => 'required',
        'address_number' => 'required',
      ]);


      $id = $request->id;

      $post = array();
      $post['company_name'] = $request->company_name;
      $post['address_street'] = $request->address_street;
      $post['countryCode']  = $request->countryCode;
      $post['vatNumber']   = $request->vatNumber;
      $post['address_number']      = $request->address_number;
      $post['address_zip_code'] = $request->address_zip_code;
      $post['address_city'] = $request->address_city;
      $post['address_country'] = $request->address_country;
      $post['strAddress'] = $request->strAddress;

      $updateData = DB::table('users_company_vat')->where('id', $id)->update($post);



      $notification = array(

        'status' => 'Data Updated Successfully',

        'alert-type' => 'success'

      );

      return redirect()->back()->with($notification);
    }
  }


  public function vat_list()
  {


    Paginator::useBootstrap();
    $result = DB::table('users_company_vat')->where('user_id', Auth::user()->id)->orderBy('id', 'DESC')->get();

    return view('backend.company.vat_list', [
      'page_title' => $this->page_title,
      'page_header' => 'Vat Information',

    ], with(compact('result')));
  }
}