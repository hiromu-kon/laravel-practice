import { useHandleLogin } from 'components/shared/function/Auth/AuthLisnter'
import React, { useCallback, useState } from 'react'

const LoginPage = () => {
  const [email, setEmail] = useState('')
  const [password, setPassword] = useState('')

  const { handleLogin } = useHandleLogin()
  const inputEmail = useCallback(
    (event: React.ChangeEvent<HTMLInputElement>) => {
      setEmail(event.target.value)
    },
    // eslint-disable-next-line react-hooks/exhaustive-deps
    [email]
  )

  const inputPassword = useCallback(
    (event: React.ChangeEvent<HTMLInputElement>) => {
      setPassword(event.target.value)
    },
    // eslint-disable-next-line react-hooks/exhaustive-deps
    [password]
  )

  return (
    <div className={'flex flex-col h-1/2 space-y-6 w-1/2 mx-auto mt-32 max-w-sm'}>
      <h1 className=" text-center">ログイン画面</h1>
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
      <div className="h-20" />
      <button
        className=""
        onClick={() => handleLogin(email, password)}
      >
          ログイン
      </button>
    </div>
  )
}

export default LoginPage
