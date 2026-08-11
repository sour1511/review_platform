@extends('frontend.layout')
@section('maincontent')
    @parent
    <!-- ============================ Hero Banner  Start================================== -->
    <div class="page-title-wrap pt-img-wrap"
        style="background:url({{ asset('frontend/assets/img/home_page_bg_one.jpg') }}) no-repeat;">
        <div class="container">
            <div class="col-lg-12 col-md-12">
                <div class="pt-caption text-center">
                    <h1>{{ __('messages.terms_conditions') }}</h1>
                    <p><a href="{{ Route('home') }}">{{ __('messages.home_home') }}</a><span
                            class="current-page">{{ __('messages.terms_conditions') }}</span></p>
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
                        <h4 class="text-center">Commendations and Complaints Terms and Conditions of Use</h4>

                        <p class="text-justify mt-3">
                            Welcome to "Commendations and Complaints". These Terms and Conditions of Use (hereinafter
                            referred to as "Terms") set out the terms and conditions under which you ("User") may access
                            and use the "Commendations and Complaints" website (hereinafter, the "Site"). By accessing and
                            using the Site, the User agrees to fully comply with these Terms. If you disagree with any of the
                            terms presented here, we ask that you refrain from using the Site.
                        </p>

                        <h6 class="mt-3">1. Service Description</h6>
                        <p class="text-justify mt-3">
                            Commendations and Complaints is a website that allows Users to leave reviews (complaints or
                            commendations) about individuals, businesses, organizations, institutions, or other entities with
                            which they have interacted and/or had some kind of relationship involving a monetary
                            transaction. Users who were, have been, or are still clients of product and service providers can
                            rate them, and Users who were, have been, or still are product and service providers can rate the
                            clients they have had. Appealing to freedom of speech, Review Profiles can be created by any
                            user. Once a Review Profile is created for a person, business, organization, institution, or entity,
                            other users wishing to add their own commendation or complaint can do so, provided they are
                            registered on the Site and have logged in, which implies they have accepted the Site's current
                            Terms.
                        </p>

                        <h6 class="mt-3">2. User Responsibilities</h6>
                        <p class="text-justify mt-3">
                            • The User is solely responsible for the accuracy, truthfulness, and legality of the information
                            provided to the Website, as well as in their reviews: complaints or commendations.<br/>
                            • The User commits not to publish defamatory, injurious, obscene, threatening content, to violate
                            any law or regulation, or to infringe third-party intellectual property rights.<br/>
                            • The User commits not to post false or fraudulent ratings, nor to manipulate the rating system to
                            their benefit or to the detriment of others.<br/>
                            • The User understands that the reviews (complaints or commendations) expressed on the Site
                            are the personal opinions or experiences of each user, not those of Commendations and
                            Complaints. Therefore, each User will be solely responsible for the reviews they post,
                            exempting the Website from any liability.
                        </p>

                        
                        <h6 class="mt-3">3. Liability Exclusion</h6>
                        <p class="text-justify mt-3">
                            • Commendations and Complaints acts as a platform based on freedom of speech for Users to
                            leave reviews, however, Commendations and Complaints is not responsible for the opinions,
                            comments, complaints or commendations posted by Users.<br/>
                            • In the case of legal claims for defamation or other related claims, Commendations and
                            Complaints will not be considered a party and will not be subject to compensation or penalty.<br/>
                        </p>

                        <h6 class="mt-3">4. Privacy and Data Protection</h6>
                        <p class="text-justify mt-3">
                            User data privacy and protection are important to us. Please refer to our Privacy Policy for
                            information on how we collect, use, and protect your personal data.
                        </p>

                        <h6 class="mt-3">5. Intellectual Property</h6>
                        <p class="text-justify mt-3">
                            The Site's content, including but not limited to texts, images, logos, trademarks, and software, is
                            protected by intellectual property rights and cannot be used without express authorization.
                        </p>

                        <h6 class="mt-3">6. Moderation and Content Removal</h6>
                        <p class="text-justify mt-3">
                            Commendations and Complaints reserves the right to moderate and remove any content it
                            considers contrary to these Terms or harmful to the User community.
                        </p>

                        <h6 class="mt-3">7. Limitation of Liability</h6>
                        <p class="text-justify mt-3">
                            The User acknowledges that Commendations and Complaints is not responsible for the
                            truthfulness, accuracy, or legality of the reviews (complaints or commendations) posted by the
                            Users.
                        </p>

                        <h6 class="mt-3">8. Modifications to the Terms</h6>
                        <p class="text-justify mt-3">
                            Commendations and Complaints reserves the right to modify these Terms at any time. Changes
                            will take effect once they are published on the Site.
                        </p>

                        <h6 class="mt-3">9. Access Termination</h6>
                        <p class="text-justify mt-3">
                            Commendations and Complaints may terminate or suspend the User's access to the Site in the
                            event of a breach of these Terms.
                        </p>

                        <h6 class="mt-3">10. Applicable Law</h6>
                        <p class="text-justify mt-3">
                            These Terms are governed by the laws of the country where the entity owning Commendations
                            and Complaints is registered. Any dispute arising in connection with the Site will be subject to
                            the jurisdiction of that country's courts.<br/>
                            
                            <p class="text-justify mt-3">By using the Site, it is understood that the User has read, understood, and accepted these terms
                                and conditions in their entirety. Therefore, the User agrees to comply with these Terms and
                                commits to respecting the applicable rules and regulations. If you disagree with these Terms, we
                                ask that you refrain from using the Site.</p><br/>

                            <p class="text-justify mt-2">If you have any suggestions, you can write to the email address: <b>info@quejasyelogios.com</b></p> 
                        
                        </p>
                    
                    @else

                        <h4 class="text-center">Términos y Condiciones de Uso de Quejas y Elogios</h4>

                        <p class="text-justify mt-3">
                            Bienvenido a "Quejas y Elogios". Estos Términos y Condiciones de Uso (en adelante,
                            "Términos") establecen los términos y condiciones bajo los cuales usted ("Usuario") puede
                            acceder y utilizar el sitio web "Quejas y Elogios" (en adelante, el "Sitio"). Al acceder y utilizar el
                            Sitio, el Usuario acepta cumplir con estos Términos en su totalidad. Si no está de acuerdo con
                            alguno de los términos aquí presentados, le pedimos que no utilice el Sitio.
                        </p>

                        <h6 class="mt-3">1. Descripción del Servicio</h6>
                        <p class="text-justify mt-3">
                            Quejas y Elogios es un sitio web que permite a los Usuarios dejar revisiones, quejas o elogios
                            sobre personas, empresas, organizaciones, instituciones u otros entes con los cuales hayan
                            interactuado y/o tenido algún tipo de relación en la cual haya mediado una transacción
                            monetaria. Los Usuarios que fueron, hayan sido o aún sean clientes de proveedores de productos
                            y servicios, podrán calificarlos, y los Usuarios que fueron, hayan sido o aún sean proveedores de
                            productos y servicios, podrán calificar a los clientes que hayan tenido. Apelando a la libertad de
                            expresión, los Perfiles de Revisión pueden ser creados por cualquier usuario. Una vez creado un
                            Perfil de Revisión para una persona, empresa, organización, institución o ente, los demás
                            usuarios que deseen agregar su propio elogio o queja, podrán hacerlo siempre y cuando estén
                            registrados en el Sitio y hayan iniciado sesión, lo cual implica que tendrán que haber aceptado
                            los presentes Términos del Sitio.
                        </p>

                        <h6 class="mt-3">2. Responsabilidades del Usuario</h6>
                        <p class="text-justify mt-3">
                            • El Usuario es el único responsable de la precisión, veracidad y legalidad de la información
                            que proporcione al Sitio Web así como en sus revisiones: quejas o elogios.<br/>
                            • El Usuario se compromete a no publicar contenido difamatorio, injurioso, obsceno,
                            amenazante, que viole cualquier ley o regulación o que infrinja los derechos de propiedad
                            intelectual de terceros.<br/>
                            • El Usuario se compromete a no realizar calificaciones falsas o fraudulentas, ni a manipular el
                            sistema de calificación en su propio beneficio o en detrimento de otros.<br/>
                            • El Usuario entiende que las revisiones, quejas o elogios expresados en el Sitio son las
                            opiniones o experiencias personales de cada usuario, no las de Quejas y Elogios. Por lo tanto
                            cada Usuario será el único responsable de las revisiones que publique, eximiendo al Sitio
                            Web de cualquier responsabilidad.<br/>
                        
                        </p>

                        <h6 class="mt-3">3. Exclusión de Responsabilidad</h6>
                        <p class="text-justify mt-3">
                            • Quejas y Elogios actúa como una plataforma que se fundamenta en la libertad de expresión
                            para que los Usuarios dejen revisiones, pero Quejas y Elogios no se hace responsable de las
                            opiniones, comentarios, quejas o elogios publicados por los usuarios.<br/>
                            • En caso de demandas judiciales por difamación u otros reclamos relacionados con las
                            revisiones, Quejas y Elogios no será considerado como parte ni será objeto de compensación
                            o sanción.<br/> 
                        </p>

                        <h6 class="mt-3">4. Privacidad y Protección de Datos</h6>
                        <p class="text-justify mt-3">
                            La privacidad y protección de los datos del Usuario son importantes para nosotros. Consulte
                            nuestra Política de Privacidad para obtener información sobre cómo recopilamos, utilizamos y
                            protegemos sus datos personales.
                        </p>

                        <h6 class="mt-3">5. Propiedad Intelectual</h6>
                        <p class="text-justify mt-3">
                            El contenido del Sitio, incluyendo pero no limitado a textos, imágenes, logotipos, marcas y
                            software, está protegido por derechos de propiedad intelectual y no puede ser utilizado sin
                            autorización expresa.
                        </p>

                        <h6 class="mt-3">6. Moderación y Retiro de Contenido</h6>
                        <p class="text-justify mt-3">
                            Quejas y Elogios se reserva el derecho de moderar y retirar cualquier contenido que considere
                            contrario a estos Términos o que sea perjudicial para la comunidad de Usuarios.
                        </p>

                        <h6 class="mt-3">7. Limitación de Responsabilidad</h6>
                        <p class="text-justify mt-3">
                            El Usuario reconoce que Quejas y Elogios no es responsable de la veracidad, precisión o
                            legalidad de las revisiones, quejas o elogios publicados por los Usuarios.
                        </p>

                        <h6 class="mt-3">8. Modificaciones a los Términos</h6>
                        <p class="text-justify mt-3">
                            Quejas y Elogios se reserva el derecho de modificar estos Términos en cualquier momento. Los
                            cambios entrarán en vigor una vez publicados en el Sitio.
                        </p>

                        <h6 class="mt-3">9. Terminación del Acceso</h6>
                        <p class="text-justify mt-3">
                            Quejas y Elogios puede terminar o suspender el acceso del Usuario al Sitio en caso de
                            incumplimiento de estos Términos.
                        </p>
                        
                        <h6 class="mt-3">10. Ley Aplicable</h6>
                        <p class="text-justify mt-3">
                            Estos Términos se rigen por las leyes del país donde está registrada la entidad propietaria de
                            Quejas y Elogios. Cualquier conflicto surgido en relación con el Sitio se someterá a la
                            jurisdicción de los tribunales de dicho país.
                            
                            <p class="text-justify mt-3">
                            Al utilizar el Sitio, se entiende que el Usuario ha leído, entendido y aceptado estos términos y
                            condiciones en su totalidad. Por lo tanto, el Usuario acepta cumplir con estos Términos y se
                            compromete a respetar las normas y regulaciones aplicables. Si no está de acuerdo con estos
                            Términos, le pedimos que no utilice el Sitio.</p><br/>
                            
                            <p class="text-justify mt-2">Si tiene alguna sugerencia, la puede escribir al correo electrónico: <b>info@quejasyelogios.com</b></p>
                        </p>

                    @endif
                </div>
            </div>

        </div>
    </section>
    <div class="clearfix"></div>
    <!-- ============================ Terms & Conditions End ================================== -->
@endsection
