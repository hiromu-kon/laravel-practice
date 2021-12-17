<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Http\Resources\Contact\Contact as ContactResource;
use App\Models\Contact;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

/**
 * 問い合わせコントローラー
 *
 * Class ContactController
 * @package App\Http\Controllers\Api
 */
class ContactController extends BaseController
{
    /**
     * 問い合わせを保存
     *
     * @param  ContactRequest $request
     * @return ContactResource|\Illuminate\Http\JsonResponse
     */
    public function store(ContactRequest $request)
    {
        if(Contact::exists($request->id, $request->name, $request->email, $request->content)) {
            return $this->respondNotFound("既に問い合わせが存在します。");
        }

        try {
            $validated = $request->validated();
            $contact   = new Contact($validated);
            $contact->save();
        } catch (QueryException $e) {
            return $this->respondInvalidQuery();
        }

        return new ContactResource($contact);
    }
}
