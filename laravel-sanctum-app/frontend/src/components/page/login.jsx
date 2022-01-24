import { useEffect } from "react"
import { useState } from 'react'
import axios from 'axios';
import { useNavigate } from "react-router-dom";

export const Login = () => {

  const navigate= useNavigate();
  const [email, setEmail] = useState('hirosoccer@gmailcom')
  const [password, setPassword] = useState('Hiro0405')

  const onClickLogin = () => {
    const loginParams = { email, password }
  
    axios
    .get('http://localhost:8000/sanctum/csrf-cookie', { withCredentials: true })
    .then((response) => {
      axios
      .post(
        'http://localhost:8000/api/login',
        loginParams,
        { withCredentials: true }
      )
      .then((response) => {
        console.log(response.data)
        navigate("/user");
      })
    })
  }

  const onClickRegister = () => {
    const loginParams = { 
      email: 'hiroTest10@gmailcom', 
      password: 'TestUser',
      password_confirmation: 'TestUser',
      name: 'Test'
    }

    axios
    .get('http://localhost:8000/sanctum/csrf-cookie', { withCredentials: true })
    .then((response) => {
      axios
      .post(
        'http://localhost:8000/api/register',
        loginParams,
        { withCredentials: true }
      )
      .then((response) => {
        console.log(response.data)
        navigate("/user");
      })
    })
  }

  const onClickLogout = () => {

      axios
      .post(
        'http://localhost:8000/api/logout',
        { withCredentials: true }
      )
      .then((response) => {
        console.log(response.data)
      })

  }

  return (
    <div>
      <button onClick={onClickLogin}>
        ログイン
      </button>
      Login<br/>
      <button onClick={onClickRegister}>
        新規登録
      </button><br/>
      <button onClick={onClickLogout}>
        ログアウト
      </button>
    </div>
  )
}
