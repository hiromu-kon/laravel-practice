import React, { useCallback, useState, useEffect, useContext } from 'react'
import { useHandleRegister, useHandleLogout } from '../src/components/shared/function/Auth/AuthLisnter'

const RegisterPage = () => {
  const [userName, setUserName] = useState('')
  const [email, setEmail] = useState('')
  const [password, setPassword] = useState('')

  const { handleRegister } = useHandleRegister()

  const handleLogout = useHandleLogout()

  const inputUserName = useCallback(
    (event) => {
      setUserName(event.target.value)
    },
    // eslint-disable-next-line react-hooks/exhaustive-deps
    [userName]
  )

  const inputEmail = useCallback(
    (event) => {
      setEmail(event.target.value)
    },
    // eslint-disable-next-line react-hooks/exhaustive-deps
    [email]
  )

  const inputPassword = useCallback(
    (event) => {
      setPassword(event.target.value)
    },
    // eslint-disable-next-line react-hooks/exhaustive-deps
    [password]
  )
  return (
    <h1 className={'flex flex-col h-1/2 space-y-6 w-1/2 mx-auto mt-32 max-w-sm'}>
      <label className=" text-center">会員登録画面</label>
      <span
        className={'block px-4 py-2 text-sm text-gray-700 cursor-pointer'}
        onClick={handleLogout}
        >
        ログアウト
      </span>
      <input
        type={'text'}
        placeholder="ユーザー名"
        value={userName}
        className={''}
        onChange={inputUserName}
        required={true}
      />
      <input
        onChange={inputEmail}
        placeholder="メールアドレス"
        required={true}
        type={'email'}
        value={email}
      />
      <input
        onChange={inputPassword}
        placeholder="パスワード"
        required={true}
        type={'password'}
        value={password}
      />
      <div className="h-15" />
      <button
        className=""
        onClick={() => handleRegister(userName, email, password)}
      >
          登録する
      </button>
      <div className="h-20" />
    </h1>
  )
}

export default RegisterPage
