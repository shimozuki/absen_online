
<style>
    @import url("https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap");

* {
  --dark: #E9F5DB;
  --red: #B5C99A;
}

body {
  margin: 0;
  font-family: Roboto, Arial, Helvetica, sans-serif;
  position: relative;
}

.credit {
  position: absolute;
  top: 15px;
  right: 10px;
  border-radius: 10px;
  padding: 10px;
  background-color: rgb(248, 92, 113);
      cursor: pointer;
    z-index: 2;
    overflow: hidden;
}

.credit a {
  text-decoration: none;
  color: #eee;
  padding:10px;
}

.credit:after {
  box-sizing: border-box;
  content: "";
  border: 8px solid;
  border-color: transparent transparent transparent #eee;
  width: 8px;
  height: 8px;
  position: absolute;
  right: 1px;
  top: 50%;
  transform: translateY(-50%);
  transition: all 0.5s;
}
.credit:hover::after {
  right: -3px;
}

.test {
    background-color: #1769ff;
    width: 100%;
    height: 100%;
    position: absolute;
    top: 0;
    left: -100%;
    transition: .5s ease-in-out;
    z-index: -1;
}

.credit:hover .test {
    left: 0;
}
.business2 {
  display: flex;
  align-items: center;
  min-height: 100vh;
  justify-content: center;
}

.business2 .front,
.business2 .back {
  background-color: var(--dark);
  width: 280px;
  height: 480px;
  margin: 20px;
  border-radius: 25px;
  overflow: hidden;
  position: relative;
}

.business2 svg {
  width: 50px;
}

.business2 h1,
.business2 h2,
.business2 p {
  margin: 0;
  color: #232323;
}

.business2 .red {
  height: 35%;
  background-color: var(--red);
}

.business2 .head {
  display: flex;
  justify-content: center;
  padding: 25px 0;
}

.business2 .head img {
  width: 40px;
}

.business2 .head > div {
  text-align: center;
  margin: 0 10px;
  text-transform: uppercase;
}

.business2 .head > div p {
  font-size: 0.8rem;
  font-weight: 600;
}

.business2 .avatar {
  position: absolute;
  width: 50%;
  left: 50%;
  top: 100px;
  transform: translate(-50%);
  text-align: center;
}

.business2 .img {
  background-color: #bfc2c7;
  padding: 10px;
  box-sizing: border-box;
  border-radius: 50%;
  border: 6px solid var(--dark);
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
}

.business2 .img img {
  width: 80%;
  padding: 10px 0;
}

.business2 .avatar p:nth-of-type(1) {
  text-transform: uppercase;
  font-weight: 900;
}

.business2 .infos {
  position: absolute;
  bottom: 5%;
  left: 5%;
}

.business2 .infos > div {
  display: flex;
  margin: 5px;
}

.business2 .infos > div svg {
  width: 25px;
  height: 25px;
  margin-right: 10px;
  background-color: var(--red);
  padding: 8px;
  border-radius: 7px;
}

.business2 .infos > div p {
  font-size: 0.8rem;
  margin: 5px 0;
  font-weight: 500;
}

/* back*/
.business2 .back .top {
  width: 100%;
  box-sizing: border-box;
  height: 70%;
  background: url("https://raw.githubusercontent.com/MohcineDev/Business-Card/main/imgs/e.webp")
    center;
  filter: contrast(160%);
  position: relative;
}

.business2 .back .top::after {
  content: "";
  width: 100%;
  height: 100%;
  position: absolute;
  z-index: 10;
  background: linear-gradient(rgba(71, 11, 11, 0.8), rgba(240, 8, 8, 0.5));
}

.business2 .back .top {
  position: relative;
}

.business2 .back .top div img {
  width: 40px;
  margin: 10px;
}

.business2 .back .top div {
  position: absolute;
  display: flex;
  flex-direction: column;
  align-items: center;
  top: 40%;
  left: 19%;
  z-index: 11;
  filter: contrast(80%);
  text-transform: uppercase;
}

.webicon {
  background-color: var(--dark);
  border-radius: 50%;
  width: 70%;
  padding: 20px 0;
  position: absolute;
  top: calc(70% - 40px);
  left: 15%;
  display: flex;
  align-items: center;
  justify-content: center;
}

.webicon div {
  background-color: var(--red);
  border-radius: 50%;
  padding: 5px 4px 2px 5px;
}

.business2 .back > p {
  text-align: center;
  margin-top: 30%;
  color: var(--red);
}

</style>
<div class="business2">

    <div class="front">
        <div class="red">

            <div class="head">
                <img src="https://raw.githubusercontent.com/MohcineDev/Business-Card/cf4dc2abb23ae9e4ffcb786b7b69bd550cfc3d0a/imgs/x.svg" alt="logo">
                <div>
                    <h2>SDN 2 Langam</h2>
                    <p>Kec.Lopok Sumbawa</p>
                </div>
            </div>
        </div>
        @foreach ($data as $k) 
        <div class="avatar">
            <div class="img">

                <img src="https://raw.githubusercontent.com/MohcineDev/Business-Card/main/imgs/man.png" alt="">
            </div>
            <p class="text-dark">{{ $k['nama'] }}</p>
            <p>{{ $k['kelas'] }}</p>
        </div>
        <div class="infos">
        <img src="data:image/png;base64, {{ base64_encode($k['qr']) }} ">
            
        </div>
        @endforeach
    </div>
</div>
    
    <!-- <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <style>
          .card {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
                grid-gap: 20px;
            }
            
          .kartu {
            page-break-inside: avoid;
            break-inside: avoid-column;
            display: inline-block;
            vertical-align: top;            
            height: 200px;
            width: 90px;
            border: 2px #black;
            border-style: double;
            box-shadow: 1px 1px 3px #ccc;
            margin-bottom: 15px;
            padding: 20px;            
            text-align: center;
            font-family: Sans-serif;
            font-size: 5px;
          } 
          
          .name {
            font-weight: bold;
            font-size: 7px;
            margin-bottom: 5px;
          }

          .kelas {
            font-weight: bold;
            font-size: 5px;
            margin-bottom: 5px;
          }
          .photo {      
            margin-bottom: 10px;            
          }

          .nis {
            margin-bottom: 10px;
          }

          .qr-code {
            width: 100%;
            height: 100%;
            margin: 10px auto;
            margin-bottom: 0px;
          }
        </style>
        <div class="card"> 
          @foreach ($data as $k)       
          <div class="kartu">
            <div class="photo">
              <img src="{{ public_path('/img/logo-sekolah.png') }}" class="img-fluid" width="60px" height="60px">
            </div>          
            <div class="name">
              {{ $k['nama'] }}
            </div>
            <div class="kelas">
              {{ $k['kelas'] }}
            </div>
            <div class="nis">
              NIS: {{ $k['nis'] }}
            </div>
            <div class="qr-code">
                <img src="data:image/png;base64, {{ base64_encode($k['qr']) }} ">
            </div>
          </div>
          @endforeach
        </div>     
        
        
       -->