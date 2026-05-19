@extends('format.layout')

@section('title')
    Home
@endsection

@section('content')
    <div style="margin-bottom: 40px; text-align: center;">
        <h1 style="color: #8ca9a0; font-size: 2.5rem; font-weight: 700; margin: 0;">
            STUDENT MANAGEMENT 
        </h1>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem; margin-top: 2rem;">

        <!-- CARD 1 -->
        <div style="background: #fff; padding: 2rem; border-radius: 12px; box-shadow: 0 4px 6px rgba(16, 185, 129, 0.15); transition: all 0.3s ease; cursor: pointer; text-align: center;" 
             onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 8px 12px rgba(16, 185, 129, 0.3)'" 
             onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px rgba(16, 185, 129, 0.15)'">

            <div style="width: 70px; height: 70px; background: linear-gradient(135deg, #81cfb5 0%, #5a8779 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; box-shadow: 0 4px 6px rgba(16, 185, 129, 0.25);">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="white" viewBox="0 0 16 16">
                    <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8zm-7.978-1A.261.261 0 0 1 7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.759 1.457.76 1.72l-.008.002a.274.274 0 0 1-.014.002H7.022z"/>
                </svg>
            </div>

            <h5 style="color: #059669; font-weight: 600; margin-bottom: 0.5rem;">
                View Students
            </h5>

          <p style="color: #6b7280; font-size: 0.9rem; margin-bottom: 1rem;">
                See student list
            </p>

            <a href="{{ url('/students') }}" 
               style="padding: 0.5rem 1.25rem; background-color: #e5e7eb; color: #374151; text-decoration: none; border-radius: 6px; font-weight: 600; display: inline-block; transition: background-color 0.2s ease;"
               onmouseover="this.style.backgroundColor='#d1d5db'"
               onmouseout="this.style.backgroundColor='#e5e7eb'">
            See  student list

            </a>
        </div>

        <!-- CARD 2 -->
        <div style="background: #fff; padding: 2rem; border-radius: 12px; box-shadow: 0 4px 6px rgba(16, 185, 129, 0.15); transition: all 0.3s ease; cursor: pointer; text-align: center;" 
             onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 8px 12px rgba(16, 185, 129, 0.3)'" 
             onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px rgba(16, 185, 129, 0.15)'">

            <div style="width: 70px; height: 70px; background: linear-gradient(135deg, #81cfb5 0%, #5a8779 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; box-shadow: 0 4px 6px rgba(16, 185, 129, 0.25);">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="white" viewBox="0 0 16 16">
                    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                </svg>
            </div>

            <h5 style="color: #059669; font-weight: 600; margin-bottom: 0.5rem;">
                About
            </h5>

            <p style="color: #6b7280; font-size: 0.9rem; margin-bottom: 1rem;">
                Learn more about this 
            </p>

            <a href="{{ url('/about') }}" 
               style="padding: 0.5rem 1.25rem; background-color: #e5e7eb; color: #374151; text-decoration: none; border-radius: 6px; font-weight: 600; display: inline-block; transition: background-color 0.2s ease;"
               onmouseover="this.style.backgroundColor='#d1d5db'"
               onmouseout="this.style.backgroundColor='#e5e7eb'">
                Learn More
            </a>
        </div>

    </div>
@endsection