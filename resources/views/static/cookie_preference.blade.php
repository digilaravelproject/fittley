@extends('layouts.static_header')

@section('title', 'Cookie Preference')

@section('content')
    <div class="page-header text-center py-5 mt-4" style="background-color: #1a1a1a; color: white;">
        <h2 class="mb-3">Cookie Preference</h2>
        <div>
            <a href="{{ url('/') }}" style="color: white; text-decoration: none;">
                <i class="fa fa-home"></i> Home
            </a>
            <span style="color: orange;"> > Cookie Preference</span>
        </div>
    </div>

    <div class="container py-5" style="background-color: #000; color: white;">
        {{-- Cookie Preference --}}
        <h3 class="mb-4">Cookie Preference</h3>

        <h5>1. Copyright Notice</h5>
        <p>© 2024. Fittelly Private Limited. All rights reserved.</p>
        <p>
            The content, features, and functionality on the Fittelly platform, including but not limited to text, graphics, logos, images, audio clips, video clips, user-generated content, and community interactions, are the exclusive property of Fittelly Private Limited or its licensors and are protected by copyright, trademark, and other intellectual property laws. Unauthorized use of any content or materials from this platform, including community-generated content, is prohibited.
        </p>
        <p>
            For permission requests or inquiries, please contact us at 
            <a href="mailto:fittelly24@gmail.com" style="color: orange;">fittelly24@gmail.com</a>.
        </p>

        <h5 class="mt-5">2. Trademark Notice</h5>
        <p>
            The trademarks, service marks, and logos used and displayed on the Fittelly platform are registered and unregistered trademarks of Fittelly Private Limited. Other company, product, and service names may be trademarks or service marks of their respective owners. Nothing on this platform, including in user-generated content or community sections, should be construed as granting, by implication or otherwise, any license or right to use any trademark displayed on the platform without the prior written permission of Fittelly Private Limited or the third-party owner.
        </p>

        <h5 class="mt-5">3. Disclaimer Notice</h5>
        <p>
            The information, content, and user-generated content provided on the Fittelly platform are for general informational purposes only. While we strive to provide accurate and up-to-date content, including in our community features, we make no warranties or representations of any kind, express or implied, regarding the accuracy, reliability, or completeness of the information. Your use of the platform and its content, including interactions in the community, is at your own risk.
        </p>
        <p>
            We are not responsible for any errors or omissions in the content, including user-generated content, or for any actions you take based on the information provided.
        </p>

        <h5 class="mt-5">4. Limitation of Liability Notice</h5>
        <p>
            To the fullest extent permitted by applicable law, Fittelly Private Limited and its affiliates, officers, directors, employees, and agents shall not be liable for any direct, indirect, incidental, special, consequential, or punitive damages, or any damages whatsoever, whether in an action of contract, negligence, or other tort, arising out of or in connection with your use of the Fittelly platform or any content therein, including community-generated content and interactions. This includes, without limitation, damages for loss of profits, data, or other intangible losses.
        </p>

        <h5 class="mt-5">5. Indemnification Notice</h5>
        <p>
            You agree to indemnify, defend, and hold harmless Fittelly Private Limited and its affiliates, officers, directors, employees, and agents from and against any claims, liabilities, damages, losses, costs, or expenses, including reasonable attorneys' fees, arising out of or in any way related to your use of the Fittelly platform, including community features and user-generated content, your violation of these Terms and Conditions, or your violation of any rights of another party.
        </p>

        <h5 class="mt-5">6. Governing Law and Jurisdiction Notice</h5>
        <p>
            These notices and any disputes arising out of or related to the Fittelly platform, its community features, or these notices shall be governed by and construed in accordance with the laws of India, without regard to its conflict of law principles. Any legal action or proceeding arising under these notices shall be brought exclusively in the courts located in Mumbai, Maharashtra, India.
        </p>

        {{-- Cookie Preferences --}}
        <h3 class="mt-5 mb-4">Cookie Preferences</h3>

        <h5>1. Introduction</h5>
        <p>
            At Fittelly, we use cookies and similar tracking technologies to enhance your experience on our platform, analyze usage, provide personalized content, and support interactions within our community features. This Cookie Preferences notice explains what cookies are, how we use them, and how you can manage your cookie settings.
        </p>

        <h5 class="mt-4">2. What Are Cookies?</h5>
        <p>
            Cookies are small text files placed on your device by a web server when you visit a website. They are widely used to make websites work more efficiently, enhance your experience, and provide reporting information. Cookies help us remember your preferences, improve platform performance, and facilitate your participation in community activities.
        </p>

        <h5 class="mt-4">3. Types of Cookies We Use</h5>
        <ul>
            <li><strong>Essential Cookies:</strong> Necessary for the platform to function and cannot be turned off. Enable navigation, use of community features, and secure login.</li>
            <li><strong>Performance Cookies:</strong> Collect information on how you use our platform, including community interactions, to help us improve performance and fix issues.</li>
            <li><strong>Functional Cookies:</strong> Remember preferences like language, login details, and interactions to enhance your experience.</li>
            <li><strong>Targeting Cookies:</strong> Deliver relevant ads across the platform and other websites and help measure campaign effectiveness.</li>
        </ul>

        <h5 class="mt-4">4. How We Use Cookies</h5>
        <p>We use cookies to:</p>
        <ul>
            <li>Improve platform and community feature performance</li>
            <li>Personalize content and recommend relevant posts or challenges</li>
            <li>Analyze usage trends and interactions</li>
            <li>Serve relevant ads and track their performance</li>
        </ul>

        <h5 class="mt-4">5. Managing Your Cookie Preferences</h5>
        <p>
            You can manage your cookie preferences through your browser settings. Most browsers allow you to refuse or accept cookies, delete cookies, or notify you when a cookie is being placed. Refer to your browser's help section for details. Disabling cookies may reduce platform functionality, including community features.
        </p>

        <h5 class="mt-4">6. Third-Party Cookies</h5>
        <p>
            We may use third-party cookies from trusted partners to analyze usage, deliver ads, and improve services, including community interactions. Please review their privacy policies for more info.
        </p>

        <h5 class="mt-4">7. Changes to Cookie Preferences</h5>
        <p>
            We may update our Cookie Preferences notice from time to time. Any changes will be posted on this page. Continued use of the platform indicates acceptance of updates.
        </p>

        <h5 class="mt-4">8. Contact Us</h5>
        <p>
            If you have any questions about our use of cookies or how to manage your preferences, please contact us at:
        </p>
        <ul>
            <li><strong>Email:</strong> <a href="mailto:support@fittelly.com" style="color: orange;">support@fittelly.com</a></li>
            <li><strong>Phone:</strong> +919920888443</li>
        </ul>
    </div>
@endsection
