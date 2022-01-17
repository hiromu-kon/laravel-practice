import Head from 'next/head'
import Image from 'next/image'
import axios from "../src/libs/axios";
import React, { useEffect } from 'react';

export default function Home() {

  useEffect(() => {
    axios.get("/api/books").then((res) => {
    const data = res.data;
    console.log(data);
   });
  }, []);

  return (
    <div>
      テスト
    </div>
  )
}
