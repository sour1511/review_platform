@extends('frontend.layout')
@section('maincontent')
    @parent
    <!-- ============================ Hero Banner  Start================================== -->
    <div class="page-title-wrap pt-img-wrap"
        style="background:url({{ asset('frontend/assets/img/home_page_bg_one.jpg') }}) no-repeat;">
        <div class="container">
            <div class="col-lg-12 col-md-12">
                <div class="pt-caption text-center">
                    <h1>{{ __('messages.Privacy') }}</h1>
                    <p><a href="{{ Route('home') }}">{{ __('messages.home_home') }}</a><span
                            class="current-page">{{ __('messages.Privacy') }}</span></p>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <!-- ============================ Hero Banner End ================================== -->

    <!-- ============================ Terms & Conditions Start ================================== -->
    <section class="gray" id="contact_us">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    @if (Session::get('locale') == 'en')
                        <h4 class="text-center">Privacy Policy for Commendations and Complaints</h4>

                        <p class="text-justify mt-3">
                            This Privacy Policy outlines how personal information from users ("Users") is collected, used,
                            and protected on the "Commendations and Complaints" website. By accessing and using the
                            website, Users agree to this Privacy Policy.
                        </p>

                        <h6 class="mt-3">Information Collection</h6>
                        <p class="text-justify mt-3">
                            Anyone can visit the Commendations and Complaints website without providing personal
                            information. However, to access the entirety of the reviews, that is, to read any commendation or
                            complaint made by other Users, it is necessary to register on the website as a User.

                            <p class="text-justify mt-3"><b>When a User registers on the website, we collect the following personal information:</b></p>

                            • User's first and last name<br/>
                            • Email address<br/>
                            • Gender or sex<br/>
                            • Date of birth<br/>
                            • User's photo<br/>
                            • Nickname or alias<br/>
                            • Country of origin<br/>
                            • User's image or avatar<br/>                            
                        </p>

                        <h6 class="mt-3">Use of Information</h6>
                        <p class="text-justify mt-3">
                            <p class="text-justify mb-0">The gathered information is used in the following ways:</p><br/>

                            • To provide full access to reviews and Review Profiles on the website.<br/>
                            • To allow Users to submit commendations and complaints.<br/>
                            • For statistical and commercial purposes, in the event that third parties or companies are
                            interested in understanding the performance of individuals, businesses, organizations,
                            institutions, or other entities in various fields or activities.<br/>
                        </p>

                        <h6 class="mt-3">Visibility of Information</h6>
                        <p class="text-justify mt-3">
                            Review Profiles (commendations and complaints) information may be partially viewed by any
                            non-registered user on the website. However, registered Users will have full access to reviews
                            and the Review Profiles. Every user wishing to submit a commendation or complaint must
                            register a User account.
                        </p>
                        <p class="text-justify mt-3">
                            It is important to emphasize that any individual, business, organization, institution, or other
                            entity can be the subject of a commendation or complaint, without the need for prior permission.
                            This aligns with freedom of expression and the essence of the website as a platform for Users to
                            voice their opinions about third parties with whom they have had interactions.
                        </p>

                        <h6 class="mt-3">Posting of Commendations and Complaints</h6>
                        <p class="text-justify mt-3">
                            Users will have two options for posting their commendations and complaints: 
                            1) they can use their actual personal data: their name as it appears on their ID and a real photo of their face or 
                            2) they can use their incognito or anonymous personal data: a nickname or alias and an avatar
                            photo/image. (Both the real personal data and the avatar or incognito data must be provided by
                            the User at the time they register with Commendations and Complaints). However, when a User
                            chooses to post their review (whether it's a commendation or complaint) as a Verified Review,
                            they must accept that such review will appear under their real name and photo. If the User
                            chooses to publish their review as Not Verified, they can decide with which personal data they
                            prefer to make the publication: the real ones or the incognito ones.
                        </p>

                        <h6 class="mt-3">Use of Data and Withdrawal of Information</h6>
                        <p class="text-justify mt-3">
                            • Commendations and Complaints may use the information of registered Users and reviews for
                            statistical and commercial purposes, always respecting the privacy and anonymity of Users.
                        </p>
                        <p class="text-justify mt-3">
                            • If a User decides to post their commendations and complaints anonymously or incognito, their
                            identity will be protected. However, should legal authorities request the real identity of a User
                            for justified reasons, Commendations and Complaints reserves the right to provide such
                            information.</b>
                        </p>
                        <p class="text-justify mt-3">
                            • If a User disagrees with the use of their data, they can delete their User account or ask
                            Commendations and Complaints to delete their information by writing to the following email
                            address: <b>info@quejasyelogios.com</b>
                        </p>

                        <h6 class="mt-3">Data Security</h6>
                        <p class="text-justify mt-3">
                            Commendations and Complaints take measures to protect Users' personal information, using
                            security protocols and data encryption.
                        </p>

                        <h6 class="mt-3">Changes to the Privacy Policy</h6>
                        <p class="text-justify mt-3">
                            Commendations and Complaints reserves the right to modify this Privacy Policy at any time.
                            Changes will become effective once published on the website.
                        </p>
                       
                        <p class="text-justify mt-3">
                            By using the website, Users accept the terms of this Privacy Policy. If you disagree with this
                            policy, we ask that you do not use the website.
                        </p>
                    @else

                        <h4 class="text-center">Política de Privacidad de Quejas y Elogios</h4>

                        <p class="text-justify mt-3">
                            Esta Política de Privacidad describe cómo se recopila, utiliza y protege la información personal
                            de los usuarios ("Usuarios") en el sitio web "Quejas y Elogios". Al acceder y utilizar el sitio web,
                            los Usuarios aceptan esta Política de Privacidad.
                        </p>

                        <h6 class="mt-3">Recopilación de Información</h6>
                        <p class="text-justify mt-3">
                            Cualquier persona puede visitar el sitio web Quejas y Elogios sin proporcionar información
                            personal. Sin embargo, para acceder a la totalidad de las revisiones, es decir, para leer cualquier
                            queja o elogio que haya sido hecho por otros Usuarios, es necesario registrarse en el sitio web
                            como Usuario.

                            <p class="text-justify mb-0"><b>Cuando un Usuario se registra en el sitio web, recopilamos la siguiente información personal:</b>
                            </p><br/>
                            • Nombre y apellidos del usuario<br/>
                            • Dirección de correo electrónico<br/>
                            • Sexo o género<br/>
                            • Fecha de nacimiento<br/>
                            • Foto del usuario<br/>
                            • Sobrenombre o apodo<br/>
                            • País de origen<br/>                            
                            • Imagen o avatar del usuario<br/>
                        </p>

                        <h6 class="mt-3">Uso de la Información</h6>
                        <p class="text-justify mt-3">
                            La información recopilada se utiliza de las siguientes formas:<br/>                        
                        
                            • Para proporcionar acceso completo a las revisiones y perfiles de revisión en el sitio web.<br/>
                            • Para permitir a los Usuarios agregar quejas y elogios.<br/>
                            • Para fines estadísticos y comerciales, en caso de que terceras personas o compañías estén
                            interesadas en comprender el desempeño de personas, empresas, organizaciones, instituciones
                            u otros entes en diversos campos o actividades.<br/>
                        </p>

                        <h6 class="mt-3">Visibilidad de la Información</h6>
                        <p class="text-justify mt-3">
                            • La información de los Perfiles de Revisión (quejas y elogios) puede ser vista de manera parcial
                            por cualquier usuario no registrado en el sitio web. Sin embargo, los Usuarios registrados
                            tendrán acceso completo a las revisiones y Perfiles de Revisión. Cada usuario que desee
                            agregar quejas o elogios, deberá registrar una cuenta de Usuario.
                        </p>
                       
                        <p class="text-justify mt-3">
                            • Es importante destacar que cualquier persona, empresa, organización, institución u otro ente
                            puede ser objeto de una queja o elogio, sin necesidad de permiso previo. Esto se alinea con la
                            libertad de expresión y con la esencia del sitio web de ser una plataforma para que los Usuarios
                            expresen sus opiniones sobre terceros con los que hayan tenido transacciones.
                        </p>

                        <h6 class="mt-3">Publicación de Quejas y Elogios</h6>
                        <p class="text-justify mt-3">
                            Los Usuarios tendrán dos opciones para publicar sus quejas y elogios: 
                            1) podrán usar sus datos
                            personales reales: su nombre como aparece en el documento de identidad y una foto real de su
                            rostro o 
                            2) podrán usar sus datos personales incógnitos o anónimos: un apodo o sobrenombre y
                            una foto/imagen avatar. (Tanto los datos personales reales como los avatar o incógnitos el
                            Usuario los deberá suministrarse en el momento que se registra con Quejas y Elogios). Sin
                            embargo, cuando un Usuario escoge publicar su revisión (ya sea una queja o elogio) como una
                            revisión Verificada, deberá aceptar que dicha revisión aparecerá bajo su nombre y foto real. Si el
                            Usuario escoge que su revisión se publique como No Verificada, podrá escoger con cuáles datos
                            personales prefiere hacer la publicación: los reales o los incógnitos.
                        </p>

                        <h6 class="mt-3">Uso de Datos y Retiro de Información</h6>
                        <p class="text-justify mt-3">
                            • Quejas y Elogios podrá utilizar la información de los Usuarios registrados y de las revisiones
                            con fines estadísticos y comerciales, siempre respetando la privacidad y anonimato de los
                            Usuarios.
                        </p>

                        <p class="text-justify mt-3">
                            • Si un Usuario decide publicar sus quejas y elogios de forma anónima o incógnita, su identidad
                            será protegida. Sin embargo, en caso de que las autoridades legales soliciten la identidad real
                            de un Usuario por razones justificadas, Quejas y Elogios se reserva el derecho de suministrar
                            dicha información.</b>
                        </p>

                        <p class="text-justify mt-3">
                            • Si un Usuario no está de acuerdo con el uso de sus datos, puede eliminar su cuenta de Usuario
                            o solicitar a Quejas y Elogios que elimine su información escribiendo a la siguiente dirección
                            de correo electrónico: <b>info@quejasyelogios.com</b>
                        </p>

                        <h6 class="mt-3">Seguridad de los Datos</h6>
                        <p class="text-justify mt-3">
                            Quejas y Elogios toma medidas para proteger la información personal de los Usuarios, utilizando
                            protocolos de seguridad y cifrado de datos.
                        </p>

                        <h6 class="mt-3">Cambios en la Política de Privacidad</h6>
                        <p class="text-justify mt-3">
                            Quejas y Elogios se reserva el derecho de modificar esta Política de Privacidad en cualquier
                            momento. Los cambios entrarán en vigor una vez publicados en el sitio web.
                        </p>                        
                        
                        <p class="text-justify mt-3">
                            Al utilizar el sitio web, los Usuarios aceptan los términos de esta Política de Privacidad. Si no
                            está de acuerdo con esta política, le pedimos que no utilice el sitio web.
                        </p>

                    @endif
                </div>
            </div>

        </div>
    </section>
    <div class="clearfix"></div>
    <!-- ============================ Terms & Conditions End ================================== -->
@endsection
